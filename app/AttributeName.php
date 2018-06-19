<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeName extends Model
{
    public function attributes()
    {
        return $this->belongsTo(Attribute::class);
    }

}
