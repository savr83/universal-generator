<?php

namespace App\Http\Controllers;

use App\Config;
use App\Destination;
use App\Http\Resources\ConfigResource;
use App\Http\Resources\ConfigsResource;
use function BenTools\CartesianProduct\cartesian_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Redirect;
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

    public function generate(Request $request, $id)
    {
        $ret = ['msg' => 'not found'];
        if ($dest = Destination::find($id)) {

            $in = [];
            $out = [];


            foreach ($dest->config->sources as $src) {
//                $in[$src->source_name] = $src->getData();
                $dataset = $src->getData();
                foreach ($src->fields as $field) {
                    foreach ($dataset as $rec) {
                        if (array_key_exists($field->name, $rec)) {
                            $in[$field->name][] = $rec[$field->name] ? $rec[$field->name] : 0;
                        }
                    }
                }
            }
/*
            foreach (cartesian_product($in) as $combination) {
                $dest->generate($combination);
            }
            return $out;
*/
            return cartesian_product($in)->count();
//            return ['config' => $dest->config->name, 'o' => $out, 'i' => $in, 'tmp' => $tmp];


            /*
            foreach ($dest->config->sources as $source) {
                switch ($source->type) {
                    case 'csv':
                        $importer = new CsvImporter(__DIR__ . "/../../../upload/{$source->type}/{$source->source_name}", true, ";");
                        foreach ($importer->get() as $data) {
                            $out[] = $dest->generate($data);
                        }
                        break;
                }
            }
            */

            $ret = ['out' => $out];
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
