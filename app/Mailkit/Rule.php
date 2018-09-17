<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasNamespaceTablePrefix;

    static public $currentRuleSet;

    public function getPriorityAttribute()
    {
        $plannedPercentage = $this->weight / self::$currentRuleSet->sum('weight');
//        $realPercentage = (self::$currentRuleSet->sum('counter') == 0) ? 0 : ($this->counter / self::$currentRuleSet->sum('counter'));
        $realPercentage = $this->counter * self::$currentRuleSet->avg('counter');
        $ret = $plannedPercentage  - $realPercentage;
        print("Priority for rule: {$this->name} is: $ret [$plannedPercentage/$realPercentage]\n");
        return $ret;
    }

    public function pool()
    {
        return $this->belongsTo(Rule::class);
    }
}
