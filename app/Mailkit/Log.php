<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use TableNameResolver;

    public function rule()
    {
        return $this->belongsTo(Pool::class);
    }
}
