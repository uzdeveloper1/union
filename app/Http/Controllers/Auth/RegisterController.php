<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::CABINET;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users' , 'nullable'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone'=> ['required', 'string', 'unique:users']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'=> $data['phone']
        ]);
    }



    public function showRegistrationForm()
    {
        return view('union.auth.register');
    }


    protected function registered(Request $request, $user)
    {
        if (session()->has('wishlist.ids')){
            $wishlist = session()->get('wishlist.ids');
            if ($user->wishlist->count() > 0){
                foreach ($wishlist as $wish){
                    if (!in_array($wish, $user->wishlist->modelKeys())){
                        $user->wishlist()->attach($wish);
                    }
                }
            }else{
                $user->wishlist()->attach(session()->get('wishlist.ids'));
            }
        }
        if (session()->has('cart')){
            $cart = session()->get('cart');
            if ($user->cart->count() > 0){
                foreach ($cart as $item){
                    if (!in_array($item['product_id'], $user->cart->modelKeys())){
                        $user->cart()->attach((int)$item['product_id'],['quantity' => $item['quantity']]);
                    }
                }
            }else{
                foreach ($cart as $item){
                    $user->cart()->attach((int) $item['product_id'], ['quantity' => $item['quantity']]);
                }
            }
        }
    }

}
