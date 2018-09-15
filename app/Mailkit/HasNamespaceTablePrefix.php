<?php
/**
 * Created by PhpStorm.
 * User: Pashka
 * Date: 9/15/2018
 * Time: 6:40 PM
 */

namespace App\Mailkit;

use Illuminate\Support\Str;

trait HasNamespaceTablePrefix
{
    public $base_namespace=__NAMESPACE__;

    public function getTable()
    {
        if (! isset($this->table)) {
            $this->setTable(str_replace(
                '\\', '', Str::snake(Str::plural(str_replace('App\\', '', $this->base_namespace) . class_basename($this)))
            ));
        }
        return $this->table;
    }
}