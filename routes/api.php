<?php

use App\Source;
use Illuminate\Http\Request;

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
Route::resource('categories', 'CategoryController');
Route::resource('products', 'ProductController');

Route::get('/configs/generate/{id}', 'ConfigController@generate');

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
