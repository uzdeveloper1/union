<?php

use App\Category;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager as VoyagerFacade;
use TCG\Voyager\Models\Page;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('union.home');
});
Route::get('/get', function () {
    return view('union.home');
});

Route::get('/product/{id}', 'ProductController@single')->name('single.product');
Route::get('/product/single/ajax', 'ProductController@showAjax')->name('single.product.ajax');
Route::get('/category/{category}/products', 'ProductController@productsByCategory')->name('category.products');
Route::get('/filter',  'ProductController@filter')->name('product.filter');
Route::post('products/image/remove','ProductController@remove')->name('product.image.remove');

Route::get('/contact', function () {
    return view('union.contact');
})->name('contact');
Route::get('/about', function () {
    $about = Page::where('title', 'like', '%about us%')->first();
    //dd($about);
    return view('union.about', ['about'=>$about]);
})->name('about');
Route::get('/posts/category-posts/{category}', 'PostController@postsByCategory')->name('post.by.category');
Route::get('/posts/post/{post}', 'PostController@singlePost' )->name('single.post');
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/qwerty', function () {
    $categories = Category::whereNull('parent_id')
        ->with('children')
        ->get();
    dump($categories);
});
Route::get('/category/{category}/option-types', 'OptionTypeController@option_types_by_category_id')->name('category.option_types');
Route::get('/related-products', "ProductController@tags");
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::post('/add-wish', 'WishlistController@addToWish')->name('add.wish');
Route::get('/get-wish', 'WishlistController@getFromWish')->name('get.wish');
Route::delete('/delete-wish', 'WishlistController@deleteFromWish')->name('remove.wish');
Route::get('/my-cabinet/wishlist', 'UserController@cabinet')->name('my.cabinet.wishlist');
Route::get('/my-cabinet/info', 'UserController@info')->name('my.cabinet.info')->middleware('auth');
Route::put('/user/{user}/update', 'UserController@update')->name('user.update')->middleware('auth');
Route::post('/add-to-cart', 'CartController@addCart')->name('add.cart');

Route::get('/new/{category_id?}', 'ProductController@newProducts')->name('new.products');

Route::get('/ft', function (){
  session()->forget('cart');
});


Route::get('/view/cart', 'CartController@viewCart')->name('view.cart');
Route::delete('/delete/cart/item/{id?}','CartController@deleteCartItem' )->name('delete.cart.item');
Route::put('/update/cart/item/{id?}','CartController@editCartItem' )->name('edit.cart.item');
