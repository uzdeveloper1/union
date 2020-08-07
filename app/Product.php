<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Category;
use TCG\Voyager\Traits\Translatable;


class Product extends Model
{
    use SoftDeletes;
    use Translatable;
    protected $translatable = ['name', 'description'];
    protected $fillable = [
        'name',
        'model',
        'slug',
        'brand_id',
        'category_id',
        'brand_id',
        'price',
        'discount_price',
        'image',
        'description',
        'active'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function brand(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function options(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'product_options');
    }


    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            __CLASS__,
            'product_tags',
            'product_id',
            'related_id'
        );
    }


    public function setNewStartAttribute($value): void
    {
        $this->attributes['new_start'] = Carbon::parse($value)->format('Y-m-d G:i');
    }

    public function setNewEndAttribute($value): void
    {
        $this->attributes['new_end'] = Carbon::parse($value)->format('Y-m-d G:i');
    }

    public function setDiscountEndAttribute($value): void
    {
        $this->attributes['discount_end'] = Carbon::parse($value)->format('Y-m-d G:i');
    }

    public function setDiscountStartAttribute($value): void
    {
        $this->attributes['discount_start'] = Carbon::parse($value)->format('Y-m-d G:i');
    }

    public function getImageAttribute($value){
        if (!empty($value)){
            return explode(',' , $value);
        }else{
            return null;
        }
    }

    public function getDiscountPercentAttribute(){
        return  (100 - round(($this->discount_price) * 100/($this->price), 0));
    }

    public function getNewAttribute($value){
        $now = strtotime(now('Asia/Tashkent'));
//        $now = time();
        $check_date = strtotime($this->new_end);
        if ($now < $check_date){
            return $value;
        }else{
            return 0;
        }
    }

    public function getDiscountAttribute($value){
        $now = strtotime(now('Asia/Tashkent'));
//        $now = time();
        $check_date = strtotime($this->discount_end);
        if ($now < $check_date){
            return $value;
        }else{
            return 0;
        }
    }
    public function wishlist(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function cart(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Cart::class);
    }


}
