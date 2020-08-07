<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Partner extends Model
{
    use Translatable;

    protected $translatable = ['description'];

    protected $fillable = [ 'company_name', 'description', 'image', 'url', 'active'];

}
