<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class OptionType extends Model
{
    use Translatable;

    protected $translatable = [
        'name',
    ];

    protected $fillable = [
        'name',
        'slug',
        'order',
        'combination'
    ];


    public function options(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Option::class, 'option_type_id','id');
    }
    public function optionsWithTranslations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Option::class, 'option_type_id','id')->with('translations');
    }



}
