<?php

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

Route::post('/payment/callback', 'App\Http\Controllers\PaymentController@callback')->middleware('payment.callback');
Route::post('/tours', 'App\Http\Controllers\Api\TourController@alltours')->middleware('payment.callback');
Route::post('/categorias', 'App\Http\Controllers\Api\TourController@allcategorias')->middleware('payment.callback');
Route::post('/tour-slug', 'App\Http\Controllers\Api\TourController@tourbyId')->middleware('payment.callback');
Route::post('/general', 'App\Http\Controllers\Api\TourController@general')->middleware('payment.callback');
Route::post('/categoria-slug', 'App\Http\Controllers\Api\TourController@categoriabyId')->middleware('payment.callback');
Route::post('/ubicaciones', 'App\Http\Controllers\Api\TourController@allubicaciones')->middleware('payment.callback');
Route::post('/ubicacion-slug', 'App\Http\Controllers\Api\TourController@ubicacionbyId')->middleware('payment.callback');
Route::post('/niubiz', 'App\Http\Controllers\Api\NiubizController@SessionToken')->middleware('payment.callback');
Route::post('/niubiz-pago', 'App\Http\Controllers\Api\NiubizController@pagoNiubiz')->name('niubiz.pago');
Route::post('/confirmar-pago', 'App\Http\Controllers\Api\NiubizController@confirmarPago')->middleware('payment.callback');
Route::post('/blogs', 'App\Http\Controllers\Api\TourController@allblog')->middleware('payment.callback');
Route::post('/blogbyId', 'App\Http\Controllers\Api\TourController@blogbyId')->middleware('payment.callback');
Route::post('/correo-contacto', 'App\Http\Controllers\Api\CorreoController@contacto')->middleware('payment.callback');
Route::post('/correo-dorado', 'App\Http\Controllers\Api\CorreoController@dorado')->middleware('payment.callback');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
