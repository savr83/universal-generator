<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasNamespaceTablePrefix;

    public function getPriorityAttribute()
    {
        $plannedPercentage = $this->weight / $this->pool()->active_rules->sum('weight');
        $realPercentage = ($this->pool()->active_rules->sum('counter') == 0) ? (1 / $this->pool()->active_rules->count()) : ($this->counter / $this->pool()->active_rules->sum('counter'));
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
