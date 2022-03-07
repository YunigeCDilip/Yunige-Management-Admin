<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\WarehouseDataController;

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
Route::get('test', function(){
    dd(Redis::get('wdata'));
});

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes(['register' => false]);

Route::get('/comming-soon', function () {
    return view('comming-soon');
})->name('comming.soon');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('user.logout');
Route::post('login', [LoginController::class, 'authenticate'])->name('login.submit');
Route::group(['middleware' => 'auth', 'as' => 'admin.'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('roles', RoleController::class);

    Route::get('wdata', [WarehouseDataController::class, 'index'])->name('wdata.index');
    Route::get('wdata/create', [WarehouseDataController::class, 'create'])->name('wdata.create');
    Route::post('wdata', [WarehouseDataController::class, 'store'])->name('wdata.store');
    Route::delete('wdata/{wdata}', [WarehouseDataController::class, 'destroy'])->name('wdata.destroy');
    Route::get('wdata/{wdata}', [WarehouseDataController::class, 'show'])->name('wdata.show');
    Route::get('wdata/{wdata}/edit', [WarehouseDataController::class, 'edit'])->name('wdata.edit');
    Route::post('wdata/{wdata}', [WarehouseDataController::class, 'update'])->name('wdata.update');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});
