<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('union.auth.login');
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return 'phone';
    }
    protected function authenticated(Request $request, $user)
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
                    }else{
                        $user->cart()->updateExistingPivot((int)$item['product_id'],['quantity' => $item['quantity']]);
                    }
                }
            }else{
                foreach ($cart as $item){
                    $user->cart()->attach((int) $item['product_id'], ['quantity' => $item['quantity']]);
                }
            }
        }
    }

    public function logout(Request $request)
    {
        if (session()->has('wishlist.ids')){
            $wishlist = session()->get('wishlist.ids');
        }
        if (session()->has('locale')){
            $locale = session()->get('locale');
        }
        if (session()->has('cart')){
            $cart = session()->get('cart');
        }
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if (isset($wishlist)){
            session()->put('wishlist.ids', $wishlist);
        }
        if (isset($locale)){
            session(['locale'=>$locale]);
        }
        if (isset($cart)){
            session()->put('cart', $cart);
        }

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/');
    }





}
