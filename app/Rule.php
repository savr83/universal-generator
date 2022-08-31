<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Franzose\ClosureTable\Models\Entity;

class Rule extends Entity implements RuleInterface
{
//    protected $table = 'rules';
    protected $closure = 'App\RuleClosure';

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
