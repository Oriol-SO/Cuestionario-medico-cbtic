<?php

use App\Http\Controllers\CuestionarioController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\TestController;
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
})->name('login');



Route::get('/inicio',[InicioController::class,'inicio'])->name('inicio');

Route::get('/test/{id}',[TestController::class,'test'])->name('test');
//oute::post('/empezar',[CuestionarioController::class,'empezarcondni'])->name('empezar');
