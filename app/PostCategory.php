<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\Post;
use TCG\Voyager\Traits\Translatable;


class PostCategory extends Model
{
    use Translatable;
    protected $translatable = ['name', 'slug'];
    public function posts(){
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
