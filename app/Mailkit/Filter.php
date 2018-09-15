<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }
}
