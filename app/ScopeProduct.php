<?php

namespace App;

trait ScopeProduct
{
    public function scopeBrand($query, $brand_name)
    {
        return $query->when($brand_name, function ($query) use ($brand_name) {
            $query->whereHas('brands', function ($query) use ($brand_name) {
                $query->where('brand_name', $brand_name);
            });
        });
    }

    public function scopePrice($query, $selected)
    {
        return $query->when($selected, function ($query) use ($selected) {
            if ($selected === 'low') {
                return $query->orderBy('price');
            } elseif ($selected === 'hight') {
                return $query->orderBy('price', 'desc');
            } elseif ($selected === 'newest') {
                return $query->orderBy('created_at', 'desc');
            }
        });
    }

    public function scopeSearch($query, $q)
    {
        return $query->when($q, function ($query) use ($q) {
            return $query->where('name', 'like', '%' . $q . '%');
        });
    }

    public static function scopeCategory($query, $category)
    {
        return $query->whereHas('categories', function ($query) use ($category) {
            $query->whereIn('slug', $category);
        });
    }
}