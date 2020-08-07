<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }

    public function editCartItem($id = null, Request $request){
        $quantity =(int)$request->get('quantity');
        if ($id !== null){
            if (Auth::check()){
                $user = Auth::user();
                $cart = $user->cart;
                if (in_array($id, $cart->modelKeys())){
                    $user->cart()->updateExistingPivot($id, ['quantity' => $quantity]);
                    return redirect()->route('view.cart');
                }
            }else{
                if (session()->has('cart')){
                    $cart = session()->get('cart');
                    $cart = collect($cart);
                    if ($cart->contains('product_id', '=',$id)){
                        $cart = $cart->map(function ($item) use ($id , $quantity){
                            if ($item['product_id'] == $id){
                                $item['quantity'] = $quantity;
                            }
                            return $item;
                        });
                        session()->forget('cart');
                        session()->put('cart', $cart->all());
                    }
                }
                return redirect()->route('view.cart');
            }
        }
    }

    public function deleteCartItem($id = null){
        if ($id !== null){
            if (Auth::check()){
                $user = Auth::user();
                $cart = $user->cart;
                if (in_array($id, $cart->modelKeys())){
                    $user->cart()->detach($id);
                    return redirect()->route('view.cart');
                }
            }else{
                if (session()->has('cart')){
                    $cart = session()->get('cart');
                    $cart = collect($cart);
                    if ($cart->contains('product_id', '=',$id)){
                        session()->push('cart', ['product_id' => $id, 'quantity' => 1]);
                        $data['exists'] = false;
                        $cart = collect(session()->get('cart'));
                        $data['total'] = $cart->sum('quantity');
                    }else{
                        $cart = $cart->map(function ($item) use ($id){
                            if ($item['product_id'] == $id){
                                $item['quantity'] += 1;
                            }
                            return $item;
                        });
                        session()->forget('cart');
                        session()->put('cart', $cart->all());
                        $data['exists'] = true;
                        $cart = collect(session()->get('cart'));
                        $data['total'] = $cart->sum('quantity');
                    }
                }else{
                    session()->push('cart', ['product_id' => $id, 'quantity' => 1]);
                    $data['exists'] = false;
                    $cart = collect(session()->get('cart'));
                    $data['total'] = $cart->sum('quantity');
                }
                $data['success'] = true;
                return  $data;
            }
        }

    }

    public function addCart(Request $request){
        if ($request->has('id')){
            $data = [];
            $id = $request->id;
            if(Auth::check()){
                $user = Auth::user();
                if (!in_array($id, $user->cart->modelKeys())) {
                    $user->cart()->attach($id, ['quantity' => 1]);
                    $data['exists'] = false;
                    $user->refresh();
                    $data['total'] = $user->cart->sum('pivot.quantity');
                }else{
                    $product = $user->cart->find($id);
                    $old_quantity = $product->pivot->quantity;
                    $old_quantity++;
                    $user->cart()->updateExistingPivot($id, ['quantity' => $old_quantity]);
                    $data['exists'] = true;
                    $user->refresh();
                    $data['total'] = $user->cart->sum('pivot.quantity');
                }
                $data['success'] = true;
                return $data;

            }else{
                if (session()->has('cart')){
                    $cart = session()->get('cart');
                    $cart = collect($cart);
                    if (!$cart->contains('product_id', '=',$id)){
                        session()->push('cart', ['product_id' => $id, 'quantity' => 1]);
                        $data['exists'] = false;
                        $cart = collect(session()->get('cart'));
                        $data['total'] = $cart->sum('quantity');
                    }else{
                        $cart = $cart->map(function ($item) use ($id){
                           if ($item['product_id'] == $id){
                               $item['quantity'] += 1;
                           }
                           return $item;
                        });
                        session()->forget('cart');
                        session()->put('cart', $cart->all());
                        $data['exists'] = true;
                        $cart = collect(session()->get('cart'));
                        $data['total'] = $cart->sum('quantity');
                    }
                }else{
                    session()->push('cart', ['product_id' => $id, 'quantity' => 1]);
                    $data['exists'] = false;
                    $cart = collect(session()->get('cart'));
                    $data['total'] = $cart->sum('quantity');
                }
                $data['success'] = true;
                return  $data;
            }
        }
    }

    public function viewCart(){
        $cart_items = null;
        $summ_of_cart = 0;
        $summ_of_discount = 0;
        $summ_of_payment = 0;
        $delivery_price = 0;
        if (Auth::check()){
            $user = Auth::user();
            $cart_items = $user->cart;
            foreach ($cart_items as $item){
                $summ_of_cart += $item->price * $item->pivot->quantity;
                if ($item->discount === 1){
                    $summ_of_discount += ($item->price - $item->discount_price) * $item->pivot->quantity;
                }
            }
            $summ_of_payment = $summ_of_cart - $summ_of_discount;
            $cart_items = $cart_items->map(function ($item){
                if ($item->discount === 1){
                    $price = $item->price;
                    $item->price = $item->discount_price;
                    $item['old_price'] = $price;
                    $item['item_total_sum'] = $item->price * $item->pivot->quantity;
                }else{
                    $item['item_total_sum'] = $item->price * $item->pivot->quantity;
                }

                return $item;
            });

        }else{
            if (\Session::has('cart')){
                $cart = session()->get('cart');
                $cart = collect($cart);
                $products = $cart->map(function ($product){
                    return (int)$product['product_id'];
                });
                if (!empty($cart)){
                    $cart_items = Product::find($products);
                    foreach ($cart_items as $cart_item){
                        $current_product_in_session = $cart->where('product_id', '=', $cart_item->id)->first();
                        $summ_of_cart += $cart_item->price * $current_product_in_session['quantity'];
                        if ($cart_item->discount === 1){
                            $price = $cart_item->price;
                            $summ_of_discount = ($cart_item->price - $cart_item->discount_price) * $current_product_in_session['quantity'];
                            $cart_item->price = $cart_item->discount_price;
                            $cart_item['old_price'] = $price;
                            $cart_item['item_total_sum'] = $cart_item->price *  $current_product_in_session['quantity'];
                        }else{
                            $cart_item['item_total_sum'] = $cart_item->price * $current_product_in_session['quantity'];
                        }
                        $cart_item['pivot'] = ['product_id' => $cart_item->id, 'quantity' => $current_product_in_session['quantity']];
                    }
                    $summ_of_payment = $summ_of_cart - $summ_of_discount;
                }

            }
        }
        if (isset($cart_items)){
            if ($cart_items->count() < 5){
                $delivery_price = (int) setting('site.delivery_price');
                $summ_of_payment += $delivery_price;
            }
        }

        return view('users.cart', [
            'cart_items' =>$cart_items,
            'sum_of_cart'=>$summ_of_cart,
            'sum_of_discount'=>$summ_of_discount,
            'sum_of_payment'=>$summ_of_payment,
            'delivery_price' => $delivery_price
        ]);
    }
}
