<?php

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/action/favorite', 'FavoriteAction');
Route::get('/ping', function() {
    return response()->json(['message' => 'pong']);
});

Route::get('customers', 'ApiController@getCustomers');
Route::post('customers', 'ApiController@postCustomers');

# 引数なし
Route::get('no_args', function() {
    Artisan::call('no-args-command');
});

# 引数あり
Route::get('/with_args', function() {
    Artisan::call('with-args-command', [
        'arg' => 'value',
        '--switch' => false
    ]);
});

# 購入情報のバッチ仮受信用のAPI
Route::post('/import-orders', function (Request $request) {
    $json = $request->getContent();
    file_put_contents('/tmp/orders_api', $json);
    return response('ok');
});

Route::post('/review', 'Review\\RegisterAction');
Route::get('/review', 'Review\\ReadAction');

Route::get('/users', 'UserAction');