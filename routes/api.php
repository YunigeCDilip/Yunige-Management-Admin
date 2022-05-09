<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PicController;
use App\Http\Controllers\API\StatusController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DeliveryController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\API\ItemMasterController;
use App\Http\Controllers\API\BarcodeItemController;
use App\Http\Controllers\API\ClientMasterController;
use App\Http\Controllers\API\WarehouseDataController;
use App\Http\Controllers\API\ClientMasterDataController;

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

    Route::get('status', [StatusController::class, 'index']);
    Route::get('pics', [PicController::class, 'index']);
    Route::get('categories', [CategoryController::class, 'index']);

    Route::get('client-shippers', [ClientMasterDataController::class, 'shippers']);
    Route::get('client-categories', [ClientMasterDataController::class, 'categories']);
    Route::get('clients', [ClientMasterController::class, 'index']);
    Route::delete('clients/{client}', [ClientMasterController::class, 'destory']);
    Route::post('clients', [ClientMasterController::class, 'store']);
    Route::get('clients/{client}', [ClientMasterController::class, 'show']);
    Route::put('clients/{client}', [ClientMasterController::class, 'update']);

    Route::get('carriers', [DeliveryController::class, 'index']);

    Route::get('wdata', [WarehouseDataController::class, 'index']);
    Route::get('wdata/{id}', [WarehouseDataController::class, 'show']);
    Route::post('wdata', [WarehouseDataController::class, 'store']);
    Route::put('wdata/{id}', [WarehouseDataController::class, 'update']);
    Route::delete('wdata/{id}', [WarehouseDataController::class, 'destroy']);

    Route::get('barcode-items', [BarcodeItemController::class, 'index']);

    Route::get('master-items', [ItemMasterController::class, 'index']);
    Route::get('master-items/{id}', [ItemMasterController::class, 'show']);
});
