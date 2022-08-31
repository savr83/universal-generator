<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasNamespaceTablePrefix;

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }
}
