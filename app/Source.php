<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use IteratorAggregate;
use Tools\CsvImporter;

class Source extends Model implements IteratorAggregate
{
    public function config()
    {
        return $this->belongsTo(Config::class);
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function getIterator()
    {
        switch ($this->type) {
            case 'csv':
                $importer = new CsvImporter(__DIR__ . "/../upload/{$this->type}/{$this->source_name}", true, ";");
                return $importer->message !== "" ? $importer->message : $importer->get();
                break;
        }
        return [];
    }
}
