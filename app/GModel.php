<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GModel extends Model
{
    /**
     * Creates or updates record
     *
     * @param string $tableName
     * @param array $conditions
     * @param array $values
     *
     * @return integer
     */
    public static function createOrUpdate($tableName, $conditions, $values) {
        $row = DB::table($tableName)->where($conditions)->first();
        if ($row === null) {
            $row = DB::table($tableName)->insert($values);
            Session::flash('footer_message', "CREATED");
        } else {
            DB::table($tableName)->where('id', $row->id)->update($values);
            Session::flash('footer_message', "EXISITING");
        }
        return $row;
    }
}
