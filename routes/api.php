<?php

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/action/favorite', 'FavoriteAction');
Route::get('/ping', function() {
    return response()->json(['message' => 'pong']);
});

Route::get('customers', function() {
    return response()->json(Customer::query()->select(['id', 'name'])->get());
});
Route::post('customers', function(Request $request) {
    // 仮実装
    if (!$request->json('name')) {
        return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    $customer = new Customer();
    $customer->name = $request->json('name');
$customer->save();
});