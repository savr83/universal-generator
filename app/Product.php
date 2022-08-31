<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = ['name'];

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
