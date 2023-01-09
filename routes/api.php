<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GroupController;
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

Route::prefix('auth')->group(function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
});


// Rotas protegidas pelo middleware de autenticação de API do Sanctum
Route::middleware('auth:sanctum')->group(function () {

    Route::delete('logout', [AuthController::class, 'logout']);
    
    Route::prefix('clients')->group(function(){
        Route::get('/', [ClientController::class, 'index']);
        Route::get('/{id}', [ClientController::class, 'show']);
        Route::get('/search/{name}', [ClientController::class, 'search']);
        Route::post('/', [ClientController::class, 'store']);
        Route::put('/{id}', [ClientController::class, 'update']);
        Route::delete('/{id}', [ClientController::class, 'destroy']);
    });

    Route::prefix('groups')->group(function(){
        Route::get('/', [GroupController::class, 'index']);
        Route::get('/{id}', [GroupController::class, 'show']);
        Route::get('/search/{name}', [GroupController::class, 'search']);
        Route::post('/', [GroupController::class, 'store']);
        Route::put('/{id}', [GroupController::class, 'update']);
        Route::delete('/{id}', [GroupController::class, 'destroy']);
        Route::get('/{groupId}/clients', [GroupController::class, 'listClients']);
        Route::post('/{groupId}/clients/{clientId}', [GroupController::class, 'addClient']);
        Route::delete('/{groupId}/clients/{clientId}', [GroupController::class, 'removeClient']);
    
    });
});







Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
