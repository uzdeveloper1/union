<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Banner extends Model
{
    use Translatable;
    protected $translatable = ['name', 'short_description','description'];
    protected $fillable = [
        'url',
        'images',
        'name',
        'short_description',
        'description',
        'active'
    ];
}
