<?php

namespace App\Http\Controllers;

use App\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
        //
    }


    public function addToWish(Request $request){
        if ($request->has('id')){
            $data = [];
            $id = $request->id;
            if(Auth::check()){
                    $user = Auth::user();
                    if (!in_array($id, $user->wishlist->modelKeys())) {
                        $user->wishlist()->attach($request->id);
                        $data['exists'] = false;
                        $user->refresh();
                        $data['total'] = $user->wishlist->count();
                    }else{
                        $user->wishlist()->detach($request->id);
                        $data['exists'] = true;
                        $user->refresh();
                        $data['total'] = $user->wishlist->count();
                    }
                    return $data;

            }else{
                if (session()->has('wishlist.ids')){
                    $wishlist = session()->get('wishlist.ids');
                    if (!in_array($id, $wishlist)){
                        session()->push('wishlist.ids' , $id);
                        $data['exists'] = false;
                        $data['total'] = count(session()->get('wishlist.ids'));
                    }else{
                        $new_wishlist = array_diff($wishlist, [$id]);
                        session()->forget('wishlist');
                        if (count($new_wishlist) > 0){
                            session()->put('wishlist.ids', $new_wishlist);
                        }
                        $data['exists'] = true;
                        $data['total'] = session()->get('wishlist.ids') ? count(session()->get('wishlist.ids')) : 0;
                    }
                }else{
                    session()->push('wishlist.ids', $id);
                    $data['exists'] = false;
                    $data['total'] = count(session()->get('wishlist.ids'));
                }
                return  $data;
            }
        }

    }

    public function getFromWish(){

    }

    public function deleteFromWish(){

    }
}
