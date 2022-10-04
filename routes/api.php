<?php

use App\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('configs', 'ConfigController'); //->name('home');
// disable temporary
//Route::resource('destinations', 'DestinationController');
//Route::resource('rules', 'RuleController');

Route::resource('categories', 'CategoryController');
Route::resource('products', 'ProductController');

Route::resource('pool', 'Mailkit\PoolController');

Route::get('/configs/generate/{id}', 'ConfigController@generate');
Route::get('/configs/import/{id}', 'ConfigController@import');

Route::post('/upload', function (Request $request) {

//    $file = $request->file('file.name');

    foreach ($request->file() as $file) {

        $file->move(__DIR__ . '/../upload/' . $file->getClientOriginalExtension(), $file->getClientOriginalName());
        $source = new Source;
        $source->config_id = 1;
        $source->type = $file->getClientOriginalExtension();
        $source->source_name = $file->getClientOriginalName();
        $source->save();
    }

    return  $request->file();
});
