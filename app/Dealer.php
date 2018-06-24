<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $fillable = ['name', 'short_name', 'contact_id'];

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
