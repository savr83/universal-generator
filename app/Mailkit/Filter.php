<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasNamespaceTablePrefix;

    const ACTION_NOACTION = "NOACTION";
    const ACTION_SEND = "SEND";
    const ACTION_REJECT = "REJECT";

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }
}
