<?php
if (! function_exists('inWish')) {
    function inWish($product_id): bool
    {
        if (\Auth::check()){
            $user = \Auth::user();
            if($user->wishlist->count() > 0){
                $wishlist = $user->wishlist->modelKeys();
                return in_array($product_id, $wishlist);
            }
            return false;
        }else{
            if (Session::has('wishlist.ids')){
                $wishlist = session('wishlist.ids');
                return in_array($product_id, $wishlist);
            }
            return  false;

        }
    }
}

if (! function_exists('inCart')) {
    function inCart($product_id): bool
    {
        if (\Auth::check()){
            $user = \Auth::user();
            if($user->cart->count() > 0){
                $cart = $user->cart->modelKeys();
                return in_array($product_id, $cart);
            }
            return false;
        }else{
            if (Session::has('cart')){
                $cart = session('cart');
                $cart = collect($cart);
                return $cart->contains('product_id', '=' , $product_id);
            }
            return  false;
        }
    }
}
