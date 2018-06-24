<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Category;
use App\Config;
use App\Contact;
use App\Dealer;
use App\Destination;
use App\Http\Resources\ConfigResource;
use App\Http\Resources\ConfigsResource;
use App\Product;
use App\Source;
use App\Vendor;
use function BenTools\CartesianProduct\cartesian_product;

//use DebugBar\DebugBar;

use Barryvdh\Debugbar\Facade as Debugbar;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use Prestashop;

class ConfigController extends Controller
{
    //
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return new ConfigsResource(Config::paginate());
        } else {
            $configs = $request->user()->configs()->get();
            return view('config.index', ['configs' => $configs]);
        }
    }

    public function store(Request $request)
    {
        $config = new Config;
        $config->name = $request->input('data.name');
        $config->user()->associate(Auth::user());
        $config->save();

        return new ConfigResource($config);

//        return $request;
    }

    public function destroy(Request $request, $id)
    {
        $ret = ['msg' => 'not found'];
        if ($config = Config::find($id)) {
            $config->delete();
            $ret = ['msg' => 'success', 'id' => $id];
        }
        return $ret;
    }

    public function import(Request $request, $id)
    {
        $ret = ['msg' => 'test'];

// предусловие процедуры импорта, значения по-умолчанию для ОБЯЗАТЕЛЬНЫХ полей импорта.
        $defaults = [
            'category_id' => 1,
            'vendor_id' => 1,
            'dealer_id' => 1,
        ];
        $keywords = [
            'MODEL'
        ];

        $defContact = Contact::firstOrCreate(['id' => 1, 'name' => 'Agregat']);
        $defCategory = Category::firstOrCreate(['id' => 1, 'name' => 'Motors']);
        $defVendor = Vendor::firstOrCreate(['id' => 1, 'name' => 'agregat', 'short_name' => 'ag', 'contact_id' => 1]);
        $defDealer = Dealer::firstOrCreate(['id' => 1, 'name' => 'agregat', 'short_name' => 'ag', 'contact_id' => 1]);

        $ret = ['msg' => 'not found'];
        if ($src = Source::find($id)) {
// данные содержат имена полей(заголовки)
// после добавления IteratorAggregate в модель Source -- можно перечислять ее элементы в цикле
// каждый элемент -- ключ => значение, для CSV - заголовок => значение в столбце
            foreach ($src->getIterator() as $rec) {
// расширение поля данных из массива $defaults с захардкодеными данными
                $newRec = array_merge($rec, array_diff($rec, $defaults));
                $attributes = [];
                foreach ($src->fields as $field) {
                    if (array_key_exists($field->name, $newRec)) {
                        if ($field->default) {
                            $newRec = array_merge($rec, array_diff($newRec, [$field->name => $field->default]));
                        }
//                        Debugbar::info($newRec);
                        if ($field->validation_rule) {
// допилить позже
//                            if (($validator = $field->getValidator([[$field->name => ], [$field->name => $rec->validation_rule])->)
                        }
// уйти от захардконенного массива $defaults используя значение по умолчанию, если есть
// убрать $defaults и перенести $rec = array_merge($rec, array_diff($rec, $defaults));
//                        $attributes[] = new Attribute(['name' => $field->name, 'value' => $newRec[$field->name], 'category_id' => 1, ]);
                        $attributes[$field->name] = $newRec[$field->name];
                    }
                }
// условия для поиска и данные для создания или обновления
// $data = self::createOrUpdate($this->destination_name, $conditions, $fields);
//                        ['MODEL' => 'sdfsd', 'POWER' => sds]
//                        $product = new Product::firstOrNew(array_diff($rec,[]));

                /*
                DELETE FROM `products`;
                DELETE FROM `attributes`
                */
                Debugbar::info($rec);

                $product = Product::firstOrNew(['name' => $rec['MODEL']]); // обновление существующей или создать
//                $product = new Product(); //всегда новая модель
//                $product->name = $rec['MODEL'];
                $product->width = $rec['X'] ?: 0;
                $product->height = $rec['Y'] ?: 0;
                $product->depth = $rec['Z'] ?: 0;
                $product->weight = $rec['WEIGHT'] ?: 0;
                $product->price = $rec['PRICE'] ?: 0;
                $product->quantity = 0;

                $product->category()->associate($defCategory);
                $product->vendor()->associate($defVendor);
                $product->dealer()->associate($defDealer);

                Debugbar::info($product);

                $product->save();

                $realAttr = [];
                foreach ($attributes as $k => $v) {
//'MONTAGE' => $rec['MONTAGE']
                    $attribute = Attribute::firstOrCreate(['product_id' => $product->id, 'name' => $k]);
                    $attribute->value = $v;
                    $realAttr[] = $attribute;
                }
                $product->attributes()->saveMany($realAttr);
                $ret[] = $product;
            }
        }
        return $ret;
    }

    public function generate(Request $request, $id)
    {
        $ret = [];
        if ($dest = Destination::find($id)) {

            $in = [];
            $out = [];

            foreach ($dest->config->sources as $src) {
//                $in[$src->source_name] = $src->getData();
                foreach ($src->getIterator() as $rec) {
                    foreach ($src->fields as $field) {
// существует ли поле с таким же именем во входящих данных (CSV)
                        if (array_key_exists($field->name, $rec)) {
                            if ($field->combination) {
// для полей-комбинаций собираем уникальные значения для последующей перестановки
                                if (!array_key_exists($field->name, $in) || !in_array($rec[$field->name], $in[$field->name])) {
                                    $in[$field->name][] = $rec[$field->name];
                                }
                            } else {
// для обычный полей запомниаем значения в отдельный подмассив с индексом -- именем модели
                                $out[$rec['MODEL']][$field->name] = $rec[$field->name];
                            }
                        }
                    }
                }
            }
//            $ret['in'] = $in;
            $cp = cartesian_product($in);
            $ret['count'] = $cp->count();
            $dest->generateHeader();
            foreach ($cp as $combination) {
                $data = array_merge($combination, $out[$combination['MODEL']]);
                $dest->generateRow($data);
// слияние полученных перестановок с накопленным ранее массивом значений для данной модели
// !!! захардкоденное значение 'MODEL' поменять на маркер unique
                $ret['o'][] = $data;
            }
            $dest->generateFooter();
        }
        return $ret;
    }

    /*
            $opt = [
                'resource' => 'products',
                'display'  => 'full',
                'filter[id_category_default]' => 4,
    //            'limit'    => '0,1',
    //            'filter[cache_default_attribute]' => '[1657|1658]',
            ];
            $xml=Prestashop::get($opt);

    */
}
