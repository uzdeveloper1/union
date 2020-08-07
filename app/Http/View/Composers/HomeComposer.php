<?php


namespace App\Http\View\Composers;
use App\Banner;
use App\Category;
use App\Http\Controllers\ProductController;
use App\Partner;
use Illuminate\View\View;
use TCG\Voyager\Models\Post;

class HomeComposer
{
    protected  $banners;
    protected $partners;
    protected $feature_categories;
    protected $latest_blog;
    protected $new_products;


    public function __construct(Banner $banners, Partner $partners, Category $categories, Post $post)
    {
        $this->banners  = $banners::where('active', '=', 1)->get();
        $this->partners = $partners::where('active', '=', 1)->get();
        $this->feature_categories = $categories::where('show_branner', '=', 1)->latest()->get();
        $this->latest_blog = $post::where('status', '=', 'PUBLISHED')->latest()->limit(3)->get();
        $this->new_products_categories = ProductController::getNewProducts()->slice(0, 8);
    }

    public function compose(View $view){
            $view->with(
                [
                    'banners'  => $this->banners,
                    'partners' => $this->partners,
                    'feature_categories'=>$this->feature_categories,
                    'latest_blog'=>$this->latest_blog,
                    'new_products_categories' => $this->new_products_categories
                ]
            );
    }

}
