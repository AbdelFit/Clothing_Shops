<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    public function users()
    {
        return $this->hasMany('App\users');
    }
}
