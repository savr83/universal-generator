<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use TableNameResolver;

    public function pool()
    {
        return $this->belongsTo(Rule::class);
    }
}
