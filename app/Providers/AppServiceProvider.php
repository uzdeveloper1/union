<?php

namespace App\Providers;

use App\Category;
use App\PostCategory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('VoyagerGuard', function () {
            return 'admin';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();
        $post_categories = PostCategory::all();
        View::share([
            'categories'  => $categories,
            'post_categories' => $post_categories,
        ]);
        view()->composer('*', function($view){
            $wishlist_count = 0;
            $cart_amount = 0;
            if (\Auth::check()){
                if (\Auth::user()->wishlist !== null){
                    $wishlist_count = \Auth::user()->wishlist->count();
                }
                if (\Auth::user()->cart !== null){
                    $cart_amount = \Auth::user()->cart->sum('pivot.quantity');
                }

            }else{
                if (\Session::has('wishlist.ids')){
                    $wishlist_count = count(session('wishlist.ids'));
                }
                if (\Session::has('cart')){
                    $cart = session()->get('cart');
                    $cart = collect($cart);
                    $cart_amount = $cart->sum('quantity');
                }
            }
            $view->with([
                'wishlist_count' => $wishlist_count,
                'cart_amount'=>$cart_amount
            ]);
        });

    }
}
