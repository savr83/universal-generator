<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //
    protected $fillable = ['name'];

    public function sources()
    {
        return $this->hasMany(Source::class);
    }

    public function destination()
    {
        return $this->hasMany(Destination::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
