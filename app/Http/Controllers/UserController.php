<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {

        if (\Hash::check($request->old_password, $user->password)){
            $validator = \Validator::make($request->all(),[
                'name' => 'required|string|max:255',
                'email'=>[
                    'nullable',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id)
                ],
                'password' => ['required', 'string', 'min:4', 'confirmed']
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $user->name = $request->name;
            if($request->email !== null){
                $user->email = $request->email;
            }
            $user->password = \Hash::make($request->password);
            $user->update();
            return redirect()->back()->with([
                'message'    => __('voyager::generic.successfully_updated')." User ",
                'alert-type' => 'success',
            ]);
        }else{
            return redirect()->back()->with([
                'old_password_error'    => __('web.old_password_error')
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cabinet(){
        $wishlist = null;
        if (Auth::check()){
            $user = Auth::user();
            $wishlist = $user->wishlist;
        }else{
            if (\Session::has('wishlist.ids')){
                $wishlist = session()->get('wishlist.ids');
                $wishlist = Product::find($wishlist);
            }
        }
        return view('users.wishlist', [
            'wishlist' =>$wishlist
        ]);
    }
    public function info(){
        $user = Auth::user();
        return view('users.info',
        [
            'user' => $user
        ]);
    }



}
