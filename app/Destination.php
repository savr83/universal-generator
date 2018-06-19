<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class Destination extends GModel
{
    public function config()
    {
        return $this->belongsTo(Config::class);
    }

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function gen2($combination)
    {
//        return ['c' => $combination, 't' => 'lalala'];
        return "{$combination['MODEL']} => {$combination['PRICE']}\n";
    }

    public function generate($combination)
    {
        // Ветвление по типу выходных данных: csv, xml, txt, db, db_new
        switch ($this->type){

            // Сохранение записи в СУЩЕСТВУЮЩУЮ таблицу
            case 'db':
                // input: CSV -> $record - > blade -> fields[$field_name] = $value_blade
                // наполнение временного массива парами ключ-значение: имя_поля => значение
                // массив условий -- только для уникальных правил (rule->unique == true)
                //
                // data: $fields_new

                $fields = [];
                $conditions = [];
                foreach ($this->rules as $rule) {
                    if (array_key_exists($rule->name, $combination)) {
                        $blade = Blade::compileString($rule->logic);
                        // костыль!!! поменять!
                        $value = "" . view('renderer', ['blade' => $blade, 'record' => $combination]);
                        $fields[$rule->name] = $value;
                        if ($rule->unique) $conditions[] = [$rule->name, '=', $value];
                    }
                }
                // проверка на существование таблицы и создание новой или обновление существующей таблицы
                // старые поля НЕ УДАЛЯЮТСЯ!!!
                if (!Schema::hasTable($this->destination_name)){
                    Schema::create($this->destination_name, function($table) use ($fields)
                    {
                        $table->increments('id');
                        foreach ($fields as $name => $value) {
                            $table->text($name)->nullable();
                        }
                    });
                } else {
                    Schema::table($this->destination_name, function($table) use ($fields) {
                        $fields_existing = Schema::getColumnListing($this->destination_name);
                        $fields_new = array_diff(array_keys($fields), $fields_existing);
                        foreach ($fields_new as $value) {
                            // сhange() ???
                            $table->text($value)->nullable();
                        }
                    });
// для особых случаев некорректных данных -- проверять количество уникальных записей
                }
                $data = self::createOrUpdate($this->destination_name, $conditions, $fields);
                return $data;
//                    return ['fields' => $fields, 'conditions' => $conditions];
            // $fields;
                break;
            case 'db_new':
// Добавить значение в ENUM с ПОМОЩЬЮ МИГРАЦИИ!!!
                break;
            case 'xml':
                break;
        }

    }
}
