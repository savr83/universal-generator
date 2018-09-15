<?php
/**
 * Created by PhpStorm.
 * User: Pashka
 * Date: 9/15/2018
 * Time: 6:40 PM
 */

namespace App\Mailkit;


use Illuminate\Support\Str;

trait TableNameResolver
{
    public $base_namespace=__NAMESPACE__;

    public function getTable()
    {
        if (! isset($this->table)) {
            $this->setTable(str_replace(
                '\\', '', Str::snake(Str::plural(trim(str_after(get_class($this),trim($this->base_namespace,'\\')),'\\')))
            ));
        }
        return $this->table;
    }
}