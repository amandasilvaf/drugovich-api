<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GroupController;
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

Route::middleware('auth:sanctum')->group(function () {

    Route::delete('logout', [AuthController::class, 'logout']);

    Route::prefix('clients')->group(function(){
        Route::get('/', [ClientController::class, 'index'])->middleware('ability:client-list');
        Route::get('/{id}', [ClientController::class, 'show'])->middleware('ability:client-read');
        Route::get('/search/{name}', [ClientController::class, 'search'])->middleware('ability:client-search');
        Route::post('/', [ClientController::class, 'store'])->middleware('ability:client-store');
        Route::put('/{id}', [ClientController::class, 'update'])->middleware('ability:client-update');
        Route::delete('/{id}', [ClientController::class, 'destroy'])->middleware('ability:client-delete');
    });
       
    Route::prefix('groups')->group(function(){
        Route::get('/', [GroupController::class, 'index'])->middleware('ability:group-list');
        Route::get('/{id}', [GroupController::class, 'show'])->middleware('ability:group-read');
        Route::get('/search/{name}', [GroupController::class, 'search'])->middleware('ability:group-search');
        Route::post('/', [GroupController::class, 'store'])->middleware('ability:group:store');
        Route::put('/{id}', [GroupController::class, 'update'])->middleware('ability:group:update');
        Route::delete('/{id}', [GroupController::class, 'destroy'])->middleware('ability:group:delete');
        Route::get('/{groupId}/clients', [GroupController::class, 'listClients'])->middleware('ability:group-client-list');
        Route::post('/{groupId}/clients/{clientId}', [GroupController::class, 'addClient'])->middleware('ability:group-client-add');
        Route::delete('/{groupId}/clients/{clientId}', [GroupController::class, 'removeClient'])->middleware('ability:group-client-remove');
    });
});


