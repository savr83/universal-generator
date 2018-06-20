<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use function BenTools\CartesianProduct\cartesian_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/config', 'ConfigController@index'); //->name('home');

Route::get('/redirect_code', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://lara/auth/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://lara/oauth/authorize?' . $query);
});

Route::get('/redirect_token', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://lara/auth/callback',
        'response_type' => 'token',
        'scope' => '',
    ]);

    return redirect('http://lara/oauth/authorize?' . $query);
});


Route::get('/auth/callback', function (Request $request) {

    if ($request->code) {

        $http = new GuzzleHttp\Client;

        $response = $http->post('http://lara/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => '3',
                'client_secret' => 'pYvOQX8RdgpOWiXCab1k8jehkzhZfH0NCBF3ust7',
                'redirect_uri' => 'http://lara/auth/callback',
                'code' => $request->code,
            ],
        ]);

        return json_decode((string)$response->getBody(), true);
    } else {
        return var_export($request, true);
    }
});

Route::get('/permut', function () {
    $array1 = ['a' => ['1', '2'], 'b'  => ['3', '4'], 'c'  => ['5', '6', '7']];
    $array2 = ['f', 'g', 'h', 'i'];
    $array3 = ['q', 'e', 'n', 'o'];
    $out = [];

/*
    foreach (cartesian_product(['a1' => $array1, 'a2' => $array2, 'a3' => $array3]) as $combination) {
        $out[] = "{$combination['a1'][0]}{$combination['a1'][1]}{$combination['a2']}{$combination['a3']}";
    }
    return ($out);
*/
    return cartesian_product(['a1' => $array1, 'a2' => $array2, 'a3' => $array3])->asArray();
});


Route::get('/validate', function () {
    $data = [
        'power2' => 100,
        'rpm' => 200
    ];

    $validator = Validator::make($data, ['power2' => 'max:50|required', 'rpm' => 'required|numeric|max:10']);

    return $validator->messages();

});

Route::get('/configs/generate/{id}', 'ConfigController@generate');
