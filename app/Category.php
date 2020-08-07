<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Category extends Model
{
    use SoftDeletes;

    use Translatable;

    protected $translatable = ['slug', 'name','description'];

    protected $fillable = ['slug', 'name', 'description', 'image'];

    protected $table = 'categories';

    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentId(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->with('children')->orderBy('order', 'asc');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function optionTypes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            OptionType::class,
            'category_optiontypes'
        )->with('translations', 'options');
    }

}
