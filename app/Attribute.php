<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
/*
    public function attributes_name()
    {
        return $this->hasMany(AttributeName::class);
    }
*/

    protected $fillable = ['name', 'value', 'category_id'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    // возможно не нужно ?
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
