<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
