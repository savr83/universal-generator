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

    public static function getValidator($data, $rules)
    {
/*
        $data = [
            'power2' => 100,
            'rpm' => 200
        ];

        $validator = Validator::make($data, ['power2' => 'max:50|required', 'rpm' => 'required|numeric|max:10']);
*/

        return Validator::make($data, $rules);
    }
}
