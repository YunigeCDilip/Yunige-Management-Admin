<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\RoleController;
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
Route::post('auth/login', [AuthController::class, 'authenticate']);
Route::middleware('auth:sanctum')->group(function() {
    Route::get('auth/user', [AuthController::class, 'user']);

    /*
    |--------------------------------------------------------------------------
    | Roles API Routes
    |--------------------------------------------------------------------------
    */
    Route::get('permissions', [RoleController::class, 'permissions']);
    Route::get('roles/all', [RoleController::class, 'all']);
    Route::resource('roles', RoleController::class);
});
