<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasNamespaceTablePrefix;

    const ACTION_DEFAULT = "DEFAULT";
    const ACTION_SEND = "SEND";
    const ACTION_REPLY = "REPLY";
    const ACTION_REJECT = "REJECT";

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function rule()
    {
        return $this->hasOne(Rule::class);
    }
}
