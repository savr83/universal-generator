<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    use HasNamespaceTablePrefix;

    private $activeRules = null;

    public function sources()
    {
        return $this->hasMany(Source::class);
    }
    public function filters()
    {
        return $this->hasMany(Filter::class);
    }

    public function defaultRule()
    {
        return $this->hasOne(Rule::class)->withDefault([
            'name' => config('mailkit.defaultRule.name'),
            'recipient_list' => config('mailkit.defaultRule.recipient_list')
        ]);
    }
    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function getActiveRulesAttribute()
    {
        $this->activeRules = $this->activeRules ?? $this->rules()->where('enabled', true)->orderBy('weight', 'desc');
        return $this->activeRules;
    }
}
