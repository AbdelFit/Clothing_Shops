<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'slug', 'price', 'old_price', 'brand_id', 'category_id', 'images', 'updated_at', 'created_at'
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function images()
    {
        return $this->hasMany('App\Image', 'product_id');
    }

    public function brands()
    {
        return $this->belongsToMany('App\Brand');
    }

    public function wishlists()
    {
        return $this->hasMany('App\Wishlist');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        $extraFields = [
            'images' => $this->images->pluck('file')->toArray(),
        ];
        return array_merge($array, $extraFields);
    }

}
