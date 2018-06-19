<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function attributes()
    {
        return $this->belongsTo(Attribute::class);
    }
    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }
    public function dealers()
    {
        return $this->hasMany(Dealer::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
