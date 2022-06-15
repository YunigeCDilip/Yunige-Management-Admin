<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PicController;
use App\Http\Controllers\API\SDataController;
use App\Http\Controllers\API\StatusController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DeliveryController;
use App\Http\Controllers\API\Web\UserController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\API\ItemMasterController;
use App\Http\Controllers\API\BarcodeItemController;
use App\Http\Controllers\API\ClientMasterController;
use App\Http\Controllers\API\WarehouseDataController;
use App\Http\Controllers\API\ItemMasterDataController;
use App\Http\Controllers\API\UserProfileController;
use App\Http\Controllers\API\ClientMasterDataController;
use App\Http\Controllers\API\OutboundController;

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
    | Mobile API Routes
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

    Route::get('shippers', [ClientMasterDataController::class, 'shippers']);
    Route::get('item-categories', [ItemMasterDataController::class, 'categories']);
    Route::get('item-labels', [ItemMasterDataController::class, 'labels']);
    Route::get('item-brands', [ItemMasterDataController::class, 'brands']);
    Route::get('product-types', [ItemMasterDataController::class, 'types']);
    Route::get('master-items', [ItemMasterController::class, 'index']);
    Route::get('master-items/{id}', [ItemMasterController::class, 'show']);

    Route::get('barcode-items', [BarcodeItemController::class, 'index']);

    Route::get('users/profile', [UserProfileController::class, 'userProfile']);
    Route::put('users/profile', [UserProfileController::class, 'updateProfile']);

    // Route::get('users', [UserProfileController::class, 'index']);
    // Route::post('users', [UserProfileController::class, 'store']);
    // Route::get('users/{user}', [UserProfileController::class, 'show']);
    // Route::put('users/{user}', [UserProfileController::class, 'update']);
    // Route::delete('users/{user}', [UserProfileController::class, 'destory']);



    Route::get('master-items', [ItemMasterController::class, 'index']);
    Route::get('master-items/{id}', [ItemMasterController::class, 'show']);

    Route::get('sdatas', [SDataController::class, 'index']);
    Route::get('sdatas/{sdata}', [SDataController::class, 'show']);

    Route::get('wdata', [WarehouseDataController::class, 'index']);
    Route::get('wdata/{id}', [WarehouseDataController::class, 'show']);
    Route::post('wdata', [WarehouseDataController::class, 'store']);
    Route::put('wdata/{id}', [WarehouseDataController::class, 'update']);
    Route::delete('wdata/{id}', [WarehouseDataController::class, 'destroy']);

    Route::get('outbounds', [OutboundController::class, 'index']);
    Route::get('outbounds/{outbound}', [OutboundController::class, 'show']);

    Route::group(['prefix' => 'web'], function(){
        Route::get('users/lists', [UserController::class, 'index']);
    });
});
