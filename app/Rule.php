<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
