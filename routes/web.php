<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use App\CustomNamespace\PublishProcessor;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', function() {
    return view('home');
});

Route::get('auth/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('auth/register', 'Auth\RegisterController@register');
Route::get('/auth/login', 'Auth\LoginController@showLoginForm');
Route::post('/auth/login', 'Auth\LoginCOntroller@login');
Route::get('/auth/logout', 'Auth\LoginController@logout');

Route::get('/stream-response', 'StreamResponseAction');
Route::get('/payload', 'ArticlePayloadAction');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function() {
    $view = view('welcome');
    // Dispacherクラス経由でEventを実行する場合
    Event::dispatch(new PublishProcessor(1));
    return $view;
});

Route::get('/pdf', 'PdfGeneratoController@index');