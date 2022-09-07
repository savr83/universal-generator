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
    return view('index');
});

Route::get('/pi', function () {
    phpinfo();
});


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

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

Route::get('/validate', function () {
    $data = [
        'power2' => 100,
        'rpm' => 200
    ];

    $validator = Validator::make($data, ['power2' => 'max:50|required', 'rpm' => 'required|numeric|max:10']);

    return $validator->messages();

});

Route::view('/mailkit', 'mailkit.index');
