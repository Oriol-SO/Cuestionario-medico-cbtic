<?php

use App\Http\Controllers\CuestionarioController;
use App\Http\Controllers\TestController;
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

    Route::post('/inicio',[CuestionarioController::class,'enpezarcondni'])->name('enpezar');

    Route ::post('/obtenerdatos',[CuestionarioController::class,'obtenerdatos'])->name('obtener');

    Route::get('/cerrarsession',[CuestionarioController::class,'logout'])->name('logout');

    Route::post('enviarrespuestas',[TestController::class,'enviar_resuestas']);
    Route::post('enviarrespuesta_pregu',[TestController::class,'enviar_resultado']);