<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasNamespaceTablePrefix;

    public function getPriorityAttribute()
    {
        $active_rules = $this->pool->active_rules;
        $plannedPercentage = $this->weight / $active_rules->sum('weight');
        $realPercentage = ($active_rules->sum('counter') == 0) ? (1 / $active_rules->count()) : ($this->counter / $active_rules->sum('counter'));
        $ret = $plannedPercentage - $realPercentage;
        print("Priority for rule: {$this->name} is: $ret [$plannedPercentage/$realPercentage]\n");
        return $ret;
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true)->orderBy('weight', 'desc');
    }

    public function pool()
    {
        return $this->belongsTo(Rule::class);
    }
}
