<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class Destination extends GModel
{
    private $configPrefix = 'conf_';
    private $config = [];

    public function __get($key)
    {
        $r = preg_split("/{$this->configPrefix}/", $key);
        if ($tmpKey = array_key_exists(1, $r) ? $r[1] : false) {
            if (array_key_exists($this->type, $this->config) && array_key_exists($tmpKey, $this->config[$this->type]))
                return $this->config[$this->type][$tmpKey];
        }
        return parent::__get($key);
    }

    public function __set($key, $value)
    {
        $r = preg_split("/{$this->configPrefix}/", $key);
        if ($tmpKey = array_key_exists(1, $r) ? $r[1] : false) {
            return $this->config[$this->type][$tmpKey] = $value;
        }
        return parent::__set($key, $value);
    }

    public function config()
    {
        return $this->belongsTo(Config::class);
    }

    public function rules()
    {
        debugbar()->log('we are here!');
        return $this->hasMany(Rule::class);
    }

    public function gen2($combination)
    {
//        return ['c' => $combination, 't' => 'lalala'];

        return "{$combination['MODEL']} => {$combination['PRICE']}\n";
    }

    public function generateHeader()
    {
        switch ($this->type) {
            case 'core':
                break;
            case 'db':
                break;
            case 'db_new':
                break;
            case 'xml':
                $this->conf_XW = xmlwriter_open_memory();
                xmlwriter_set_indent($this->conf_XW, 1);
                xmlwriter_set_indent_string($this->conf_XW, ' ');
                xmlwriter_start_document($this->conf_XW, '1.0', 'UTF-8');
                break;
        }
    }

    public function generateFooter()
    {
        switch ($this->type) {
            case 'core':
                break;
            case 'db':
                break;
            case 'db_new':
                break;
            case 'xml':
                $file = fopen(__DIR__ . "/../upload/{$this->type}/{$this->destination_name}", "wt") or die("err");
                fputs($file, xmlwriter_output_memory($this->conf_XW));
                fclose($file);
                xmlwriter_output_memory($this->conf_XW, true);
                break;
        }

    }

    public function generateRow(
        $combination)
    {
        // Ветвление по типу выходных данных: core, csv, xml, txt, db, db_new
        // данных НЕТ в миграции!!!
        switch ($this->type) {

            case 'core':
                // заготовка
                foreach ($this->rules as $rule) {
                    if (array_key_exists($rule->name, $combination)) {
                        $blade = Blade::compileString($rule->processing_logic);
                        // костыль!!! поменять!
                        $value = "" . view('renderer', ['blade' => $blade, 'record' => $combination]);
                        $fields[$rule->name] = $value;
                        if ($rule->unique) $conditions[] = [$rule->name, '=', $value];
                    }
                }
                break;

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
                if (!Schema::hasTable($this->destination_name)) {
                    Schema::create($this->destination_name, function ($table) use ($fields) {
                        $table->increments('id');
                        foreach ($fields as $name => $value) {
                            $table->text($name)->nullable();
                        }
                    });
                } else {
                    Schema::table($this->destination_name, function ($table) use ($fields) {
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
                xmlwriter_start_element($this->conf_XW, 'offer');
                foreach ($this->rules as $rule) {
                    $blade = Blade::compileString($rule->processing_logic);
                    // костыль!!! поменять!
                    $value = "" . view('renderer', ['blade' => $blade, 'record' => $combination]);
                    xmlwriter_write_attribute($this->conf_XW, 'id', preg_replace('/\s+/', '',$combination['MODEL'] . "#" . $combination['MONTAGE']));
                    xmlwriter_write_attribute($this->conf_XW, 'productId', preg_replace('/\s+/', '',$combination['MODEL'] . "#" . $combination['DEALER']));
                    xmlwriter_write_attribute($this->conf_XW, 'quantity', '10');
                    xmlwriter_write_raw($this->conf_XW, $value);
                }
                xmlwriter_end_element($this->conf_XW);
                break;
        }

    }
}
