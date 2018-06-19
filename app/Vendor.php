<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
    public function contacts()
    {
        return $this->belongsTo(Contact::class);
    }
    public function dealers()
    {
        return $this->hasMany(Dealer::class);
    }
}
