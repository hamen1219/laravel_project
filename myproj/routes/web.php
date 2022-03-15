<?php

use App\Http\Controllers\MyController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/market-code-list', [MyController::class, 'marketCodeList']);
Route::get('/candle/{mode}', [MyController::class, 'getCandle']);
Route::get('/socket-test', [MyController::class, 'socketPage']);
Route::get('/index', [MyController::class, 'index']);

Route::post('/git/log', [MyController::class, 'addGitLog']);
