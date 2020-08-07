<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Option;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;
use TCG\Voyager\Facades\Voyager as VoyagerFacade;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerController;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Models\Translation;
/** @var \App\Product $product */

class ProductController extends Controller
{
    public $dataType;
    public $actions = [];
    public $isModelTranslatable = true;
    public $usesSoftDeletes = false;

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function single($id){
        $product = Product::findOrFail($id);
        return view('union.single', ['product' => $product]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAjax(Request $request){
        if($request->has('id')){
            $id = $request->get('id');
            $data = [];
            $product = Product::where('id', '=' , $id)->where('active', '=', 1)->first();
            if ($product){
                $data['id'] = $product->id;
                $data['brand'] = $product->brand->name;
                $data['category'] = $product->category->getTranslatedAttribute('name');
                if ($product->discount === 1){
                    $data['discount_price'] =  $product->discount_price;
                }
                $data['name'] = $product->getTranslatedAttribute('name');
                if($product->new === 1){
                    $data['new'] = true;
                }
                if ($product->discount === 1){
                    $data['discount'] = true;
                $data['discount_percent'] = $product->discount_percent;
                }
                if (inWish($product->id)){
                    $data['in_wish'] = true;
                }
                if (inCart($product->id)){
                    $data['in_cart'] = true;
                }
                $data['model'] = $product->model;
                $data['price'] = $product->price;
                $data['image'] = $product->image;
                $data['options'] = [];
                foreach ($product->options as $item){
                    $elem['key'] = $item->optiontype->getTranslatedAttribute('name');
                    $elem['value'] = $item->getTranslatedAttribute('value');
                    $data['options'][] = $elem;
                }
                $product_show_url = route('single.product',['id' => $product->id]);
                $data['share_facebook_url'] = 'https://www.facebook.com/sharer/sharer.php?u='.$product_show_url;
                $data['share_telegram_url'] = 'https://t.me/share/url?url='.$product_show_url;
                return response()->json($data);
            }
            abort('404');

        }
        abort('404');
    }

    public function __construct()
    {
        $this->dataType =  Voyager::model('DataType')->where('slug', '=', 'products')->first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::all();
        return view('vendor.voyager.products.browse',
            [
                'dataType'              => $this->dataType,
                'products'              => $products,
                'isModelTranslatable'   => $this->isModelTranslatable,
                'usesSoftDeletes'       => $this->usesSoftDeletes
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('vendor.voyager.products.edit-add',
            [
                'dataType'              => $this->dataType,
                'isModelTranslatable'   => $this->isModelTranslatable,
                'usesSoftDeletes'       => $this->usesSoftDeletes,
                'edit'                  => false,
                'categories'            => Category::all(),
                'brands'                => Brand::all()
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'model'         => 'required|string|unique:products|max:255',
            'brand_id'      => 'required|numeric',
            'category_id'   => 'required|numeric',
            'price'         => 'required|digits_between:2,20',
            'discount_price'=> 'digits_between:2,20|nullable',
            'description'   => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        \DB::transaction(function() use ($request) {
            /** @var Request $request */
            $product = new Product();
            $product->name = $request->name;
            $product->model = $request->model;
            $slug = Str::slug($request->name. ' ' . $request->model, '-');
            $product->slug = $slug;
            $product->brand_id = $request->brand_id;
            $product->price = $request->price;
            $product->new = $request->new === 'on';
            $product->new_start = $request->new_start;
            $product->new_end = $request->new_end;
            $product->discount = $request->discount === 'on';
            $product->discount_start = $request->discount_start;
            $product->discount_end = $request->discount_end;
            $product->discount_price = $request->discount === 'on' ? $request->discount_price : $request->price;
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->active = $request->active === 'on';
            $product->image = $request->has('image') ? implode(',', $this->upload($request)) : 'product-img-not-found.png';
            $product->save();
            if ($request->has('pro_options')){
                $product->options()->attach($request->pro_options);
            }
            if ($request->has('related_products')){
                $product->tags()->attach($request->related_products);
            }
            $date = now('Asia/Tashkent');
            \DB::table('translations')->insert([
                [
                    'table_name'  => 'products',
                    'column_name' => 'name',
                    'foreign_key' => $product->id,
                    'value'       => $request->name_ru ?? $request->name,
                    'locale'      => 'ru',
                    'created_at'  => $date,
                    'updated_at'  => $date
                ],
                [
                    'table_name'  => 'products',
                    'column_name' => 'name',
                    'foreign_key' => $product->id,
                    'value'       => $request->name_uz_latin ?? $request->name,
                    'locale'      => 'uz-latin',
                    'created_at'  => $date,
                    'updated_at'  => $date
                ],
                [
                    'table_name'  => 'products',
                    'column_name' => 'name',
                    'foreign_key' => $product->id,
                    'value'       => $request->name_uz_cyrillic ?? $request->name,
                    'locale'      => 'uz-cyrillic',
                    'created_at'  => $date,
                    'updated_at'  => $date
                ],
                [
                    'table_name'  => 'products',
                    'column_name' => 'description',
                    'foreign_key' => $product->id,
                    'value'       => $request->description_ru ?? $request->description,
                    'locale'      => 'ru',
                    'created_at'  => $date,
                    'updated_at'  => $date
                ],
                [
                    'table_name'  => 'products',
                    'column_name' => 'description',
                    'foreign_key' => $product->id,
                    'value'       => $request->description_uz_latin ?? $request->description,
                    'locale'      => 'uz-latin',
                    'created_at'  => $date,
                    'updated_at'  => $date
                ],
                [
                    'table_name'  => 'products',
                    'column_name' => 'description',
                    'foreign_key' => $product->id,
                    'value'       => $request->description_uz_cyrillic ?? $request->description,
                    'locale'      => 'uz-cyrillic',
                    'created_at'  => $date,
                    'updated_at'  => $date
                ],

            ]);

        });
        return redirect()->back()->with([
            'message'    => __('voyager::generic.successfully_added_new')." {$this->dataType->getTranslatedAttribute('display_name_singular')}",
            'alert-type' => 'success',
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        return  view('vendor.voyager.products.read',
            [
                'dataType' =>$this->dataType,
                'isModelTranslatable'   => $this->isModelTranslatable,
                'usesSoftDeletes'       => $this->usesSoftDeletes,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $pro_options = $product->options->modelKeys();
        return  view('vendor.voyager.products.edit',
            [
                'dataType'              => $this->dataType,
                'isModelTranslatable'   => $this->isModelTranslatable,
                'usesSoftDeletes'       => $this->usesSoftDeletes,
                'edit'                  => true,
                'categories'            => Category::all(),
                'brands'                => Brand::all(),
                'product'               => $product,
                'pro_options'           => $pro_options
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'model'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($id),
            ],
            'brand_id'      => 'required|numeric',
            'category_id'   => 'required|numeric',
            'price'         => 'required|digits_between:2,20',
            'discount_price'=> 'digits_between:2,20|nullable',
            'description'   => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        \DB::transaction(function() use ($request, $product) {
            /** @var Request $request */
            $product->name = $request->name;
            $product->model = $request->model;
            $slug = Str::slug($request->name. ' ' . $request->model, '-');
            $product->slug = $slug;
            $product->brand_id = $request->brand_id;
            $product->price = $request->price;
            $product->new = $request->new === 'on';
            $product->new_start = $request->new_start;
            $product->new_end = $request->new_end;
            $product->discount = $request->discount === 'on';
            $product->discount_start = $request->discount_start;
            $product->discount_end = $request->discount_end;
            $product->discount_price = $request->discount === 'on' ? $request->discount_price : $request->price;
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->active = $request->active === 'on';
            $pro_images = null;
            if ($request->has('old_image') && $request->old_image !== null){
                $pro_images = implode(',', $request->old_image);
            }

            if ($request->has('image') && $request->image !== null){
                if ($pro_images !== null){
                    $pro_images .=','. implode(',', $this->upload($request));
                }else{
                    $pro_images .= implode(',', $this->upload($request));
                }
            }
            if ($pro_images !== null && !empty($pro_images)){
                $product->image = $pro_images;
            }else{
                $product->image = 'product-img-not-found.png';
            }
            $product->update();
            if ($request->has('pro_options')){
                $product->options()->sync($request->pro_options);
            }
            if ($request->has('related_products')){
                $product->tags()->sync($request->related_products);
            }

            $product = $product->translate('ru');
            $product->name =  $request->name_ru ?? '';
            $product->description =  $request->description_ru ?? '';
            $product->save();
            $product = $product->translate('uz-latin');
            $product->name =  $request->name_uz_latin ?? '';
            $product->description =  $request->description_uz_latin ?? '';
            $product->save();
            $product = $product->translate('uz-cyrillic');
            $product->name =  $request->name_uz_cyrillic ?? '';
            $product->description =  $request->description_uz_cyrillic ?? '';
            $product->save();
        });
        return redirect()->back()->with([
            'message'    => __('voyager::generic.successfully_updated')." {$this->dataType->getTranslatedAttribute('display_name_singular')}",
            'alert-type' => 'success',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {


        $product = Product::findOrFail($id);
        $product->options()->detach();
        $product->tags()->detach();
        $img_dir = $product->model;
        $del_tr_id = $product->translations->map(function ($item){
            return $item->id;
        });
        Translation::destroy($del_tr_id);
        Storage::disk(config('voyager.storage.disk'))->deleteDirectory('products/'.$img_dir);
        $product->delete(s);
        return redirect()->back()->with([
            'message'    => __('voyager::generic.successfully_deleted')." {$this->dataType->getTranslatedAttribute('display_name_singular')}",
            'alert-type' => 'success',
        ]);

    }

    /**
     * @param Request $request
     * @return array
     */
    public function upload($request): array
    {
        $fullFilename = null;
        $resizeWidth = 1800;
        $resizeHeight = null;
        $slug = 'products';
        $model = $request->has('model') ? $request->model : 'no-model';
        $path = $slug.'/'.$model.'/';
        $data = [];
        if($request->hasfile('image'))
        {
            foreach($request->file('image') as $file)
            {
                $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());

                $filename_counter = 1;
                // Make sure the filename does not exist, if it does make sure to add a number to the end 1, 2, 3, etc...
                while (Storage::disk(config('voyager.storage.disk'))->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
                    $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension()).(string) ($filename_counter++);
                }
                $fullPath = $path.$filename.'.'.$file->getClientOriginalExtension();
                $name = $filename.'.'.$file->getClientOriginalExtension();
                $data[] = $fullPath;
                $ext = $file->guessClientExtension();
                if (in_array($ext, ['jpeg', 'jpg', 'png', 'gif'])) {
                    $image = Image::make($file)
                        ->resize($resizeWidth, $resizeHeight, function (Constraint $constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    if ($ext !== 'gif') {
                        $image->orientate();
                    }
                    $image->encode($file->getClientOriginalExtension(), 75);
                    // move uploaded file from temp to uploads directory
                    if (Storage::disk(config('voyager.storage.disk'))->put($fullPath, (string) $image, 'public')) {
                        $status = __('voyager::media.success_uploading');
                        $fullFilename = $fullPath;
                    } else {
                        $status = __('voyager::media.error_uploading');
                    }
                } else {
                    $status = __('voyager::media.uploading_wrong_type');
                }

            }
        }
        return $data;
    }

    public function remove(Request $request){
        $id = $request->get('id');
        $filename = $request->get('filename');
        $product = Product::findOrFail($id);
        $images = $product->image;
        if ($filename !== 'product-img-not-found.png'){
            \Storage::disk(config('voyager.storage.disk'))->delete($filename);
        }
        $images = array_diff($images, array($filename));
        $product->image = implode(',', $images);
        $product->update();
        $data['data'] = [];
        $data['data']['status'] = 200;
        $data['data']['message'] = 'Ok';
        return $data;
    }

    public function tags(Request $request){
        $q = $request->get('search');
        $data = [];
        $result['results'] = [];
        if($q !== null){
            $products = Product::where('name', 'like' , '%'.$q.'%')->get();
            $count = $products->count();
            if ($count > 0){
                foreach ($products as $product){

                    $data[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'model'=>$product->model,
                        'image' => Voyager::image($product->image[0])
                    ];
                }
                $result['results'] = $data;
                $result['total_count'] = $count;
                $result['incomplete_results'] = false;
                return $result;
            }

            $result['total_count'] = 0;
            $result['incomplete_results'] = false;
            $result['results'] = [];
            return $result;

        }
        {
            return null;
        }

    }

    public function productsByCategory(Category $category, Request $request){
        $products = Product::where('category_id', '=', $category->id);
        $products = $products->where('active', 1);
        $current_min_price = $products->min('price');
        $current_max_price = $products->max('price');

        $products2 = $products->get()->where('discount', 1);
        $current_min_price_dis = $products2->min('discount_price');
        $current_max_price_dis = $products2->max('discount_price');

        if($current_max_price <= $current_max_price_dis){
            $current_max_price = $current_max_price_dis;
        }

        if ($current_min_price >= $current_min_price_dis){
            $current_min_price = $current_min_price_dis;
        }

        $min_fil_price = $current_min_price;
        $max_fil_price = $current_max_price;

        $status = !empty($request->query());
        $selected_brands = [];
        $selected_options = [];
        if ($status){
            if ($request->query('brands')){
                $products = $products->whereIn('brand_id', $request->query('brands'));
                $selected_brands = $request->query('brands');
            }
            if ($request->query('price')){
                $price_fil = explode(';' ,$request->query('price'));
                $products = $products->whereBetween('discount_price', $price_fil);
                $min_fil_price = $price_fil[0];
                $max_fil_price = $price_fil[1];
            }
            if($request->query('options')){
                $options = $request->query('options');
                $products = $products->whereHas('options', function ($q) use ($options){
                        $q->whereIn('options.id', $options);
                });
                $selected_options = $request->query('options');
            }
        }


        return view('union.products-by-category',
            [
                'category' => $category,
                'products' => $products->latest()->paginate(10),
                'brands'   => Brand::all(),
                'from_min_price' => $min_fil_price,
                'to_max_price' => $max_fil_price,
                'max_price'=>$current_max_price,
                'min_price'=>$current_min_price,
                'selected_brands' => $selected_brands,
                'selected_options' =>$selected_options
            ]
        );

    }

    public function filter(Request $request){
        return $request;
    }

    public static function getNewProducts($category_id = null){
        if ($category_id === null){
            $categories = Category::where('parent_id' , '!=' , null)->get();
            $categories = $categories->filter(function ($category){
                return $category->products->count() > 0;
            });
        }else{
            $categories = Category::where('id', '=', $category_id)->get();
        }
        $categories = $categories->map(function ($category){
            $category->products = $category->products->map(function ($product){
                if ($product->new === 1 && $product->active === 1){
                    return $product;
                }
            })->reject(function ($product){
                return empty($product);
            });
            return $category;
        });
        return $categories;
    }

    public function newProducts($category_id = null){
        $categories = $this::getNewProducts($category_id);
        return view('union.new-products', [
            'new_categories' => $categories
        ]);
    }
}
