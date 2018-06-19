<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tools\CsvImporter;

class Source extends Model
{

    public function config()
    {
        return $this->belongsTo(Config::class);
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function getData()
    {
        switch ($this->type) {
            case 'csv':
                $importer = new CsvImporter(__DIR__ . "/../upload/{$this->type}/{$this->source_name}", true, ";");
                $this->data = $importer->get();
                break;
        }
        return $this->data;
    }

    public $data = [];
}
