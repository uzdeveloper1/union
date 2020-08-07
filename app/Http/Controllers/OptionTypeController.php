<?php

namespace App\Http\Controllers;

use App\Category;
use App\OptionType;
use Illuminate\Http\Request;

class OptionTypeController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:admin');
    }

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
     * @param  \App\OptionType  $optionType
     * @return \Illuminate\Http\Response
     */
    public function show(OptionType $optionType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OptionType  $optionType
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionType $optionType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OptionType  $optionType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionType $optionType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OptionType  $optionType
     * @return \Illuminate\Http\Response
     */
    public function destroy(OptionType $optionType)
    {
        //
    }


    public function option_types_by_category_id(Category $category){
        $admin = \Auth::guard('admin')->user();
        $admin_locale = $admin->settings['locale'] ?? 'ru';
        $option_type = $category->optionTypes;
        $option_type = $option_type->map(function ($item, $key) use ($admin_locale){
           $item = $item->only([ 'id' , 'name', 'slug', 'pivot', 'translations', 'optionsWithTranslations']);
           $item['translations'] = $item['translations']->map(function ($item2, $key2){
                return $item2->only(['locale', 'value']);
           });
           $item['translations'] = $item['translations']->filter(function ($item2, $key3) use ($admin_locale){
                return $item2['locale'] === $admin_locale;
           });
           $item['optionsWithTranslations'] = $item['optionsWithTranslations']->map(function ($item4, $key4) use ($admin_locale){
                $item4 =  $item4->only(['id', 'value', 'option_type_id', 'translations']);
                $item4['translations'] = $item4['translations']->map(function ($item4, $key4){
                   return $item4->only(['locale', 'value']);
                });
               $item4['translations'] = $item4['translations']->filter(function ($item5, $key5) use ($admin_locale){
                   return $item5['locale'] === $admin_locale;
               });

                return $item4;
           });
           return $item;
        });
        return $option_type->all();
    }
}
