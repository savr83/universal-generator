<?php

namespace App\Mailkit;

use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
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
}
