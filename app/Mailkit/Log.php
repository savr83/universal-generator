<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function rule()
    {
        return $this->belongsTo(Pool::class);
    }
}
