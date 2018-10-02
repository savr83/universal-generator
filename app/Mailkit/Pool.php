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
        $filters = $this->hasMany(Filter::class);
//        if ($filters->get()->isEmpty()) $filters = $filters->get()->push($this->defaultFilter());
        print("Inside filters call!!!\n");
        dump($filters->get());
        return $filters;
    }

    public function getActiveFiltersAttribute()
    {
        print("Inside filters ACCESSOR!!!\n");
        $value = $this->filters()->enabled();
        dump($value->get());
        print('collect($value)->isEmpty() == ' . collect($value)->isEmpty() . "\n");
        $value = collect($value)->isEmpty() ? collect($this->defaultFilter()) : $value;
        dump($value->get());
        return $value;
    }

    public function defaultFilter()
    {
        print("inside defaultFilter!!!\n");
// [A-Z0-9a-z._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,64} ???
        return $this->hasOne(Filter::class)->withDefault(function ($filter) {
            $filter->mail_field = "fromAddress";
            $filter->regexp = "/.+@.+\..+/";
            $filter->action = Filter::ACTION_REPLY;
            $filter->enabled = true;
            $filter->pool()->associate($this);
            $filter->rule()->associate($this->defaultRule());
        }
);
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
        $this->activeRules = $this->activeRules ?? $this->rules()->enabled();
        return $this->activeRules;
    }
}
