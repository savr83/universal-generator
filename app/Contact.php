<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function dealers()
    {
        return $this->hasMany(Dealer::class);
    }
    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }
}
