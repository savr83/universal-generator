<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['name', 'short_name', 'contact_id'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function dealers()
    {
        return $this->hasMany(Dealer::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
