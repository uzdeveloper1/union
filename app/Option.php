<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Option extends Model
{
    use Translatable;
    protected $translatable = ['value'];

    protected $fillable = [
        'value',
        'option_type_id'
    ];

    public function optiontype(){
        return $this->hasOne(OptionType::class, 'id', 'option_type_id');
    }
}
