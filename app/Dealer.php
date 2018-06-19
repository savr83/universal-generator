<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
