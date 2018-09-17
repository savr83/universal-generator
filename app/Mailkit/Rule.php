<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasNamespaceTablePrefix;

    static public $currentRuleSet;

    public function getPriorityAttribute()
    {
        return $this->weight / self::$currentRuleSet->sum('weight') - $this->counter / self::$currentRuleSet->sum('counter');
    }

    public function pool()
    {
        return $this->belongsTo(Rule::class);
    }
}
