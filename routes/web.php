<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\CarrierController;
use App\Http\Controllers\Backend\DeliverController;
use App\Http\Controllers\Backend\MeetingController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ShipperController;
use App\Http\Controllers\Backend\WdataPicController;
use App\Http\Controllers\Backend\ZoomRoomController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\WdataStatusController;
use App\Http\Controllers\Backend\ClientMasterController;
use App\Http\Controllers\Backend\Auth\RegisterController;
use App\Http\Controllers\Backend\InboundStatusController;
use App\Http\Controllers\Backend\WarehouseDataController;
use App\Http\Controllers\Backend\WdataCategoryController;
use App\Http\Controllers\Backend\AmazonProgressController;
use App\Http\Controllers\Backend\ClientCategoryController;
use App\Http\Controllers\Backend\MovementConfirmationController;
use App\Http\Controllers\Backend\DeliveryClassificationController;

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

Route::get('/', [HomeController::class, 'index'])->name('front.index');

// Auth::routes(['register' => false]);

Route::get('/comming-soon', function () {
    return view('comming-soon');
})->name('comming.soon');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.submit');
Route::get('logout', [LoginController::class, 'logout'])->name('user.logout');
Route::post('login', [LoginController::class, 'authenticate'])->name('login.submit');
Route::group(['middleware' => ['auth', 'check.employee'], 'as' => 'admin.'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('roles', RoleController::class);

    Route::get('shippers', [ShipperController::class, 'index'])->name('shippers.index');
    Route::post('shippers', [ShipperController::class, 'store'])->name('shippers.store');
    Route::delete('shippers/{shipper}', [ShipperController::class, 'destroy'])->name('shippers.destroy');
    Route::get('shippers/{shipper}', [ShipperController::class, 'show'])->name('shippers.show');
    Route::put('shippers/{shipper}', [ShipperController::class, 'update'])->name('shippers.update');
    
    Route::post('categories/activate', [ClientCategoryController::class, 'activate'])->name('categories.activate');
    Route::get('categories', [ClientCategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/{category}', [ClientCategoryController::class, 'show'])->name('categories.show');
    Route::post('categories', [ClientCategoryController::class, 'store'])->name('categories.store');
    Route::delete('categories/{category}', [ClientCategoryController::class, 'destroy'])->name('categories.destroy');
    Route::put('categories/{category}', [ClientCategoryController::class, 'update'])->name('categories.update');
    
    Route::post('classifications/activate', [DeliveryClassificationController::class, 'activate'])->name('classifications.activate');
    Route::get('classifications', [DeliveryClassificationController::class, 'index'])->name('classifications.index');
    Route::get('classifications/{classification}', [DeliveryClassificationController::class, 'show'])->name('classifications.show');
    Route::post('classifications', [DeliveryClassificationController::class, 'store'])->name('classifications.store');
    Route::delete('classifications/{classification}', [DeliveryClassificationController::class, 'destroy'])->name('classifications.destroy');
    Route::put('classifications/{classification}', [DeliveryClassificationController::class, 'update'])->name('classifications.update');

    Route::post('movements/activate', [MovementConfirmationController::class, 'activate'])->name('movements.activate');
    Route::get('movements', [MovementConfirmationController::class, 'index'])->name('movements.index');
    Route::get('movements/{movement}', [MovementConfirmationController::class, 'show'])->name('movements.show');
    Route::post('movements', [MovementConfirmationController::class, 'store'])->name('movements.store');
    Route::delete('movements/{movement}', [MovementConfirmationController::class, 'destroy'])->name('movements.destroy');
    Route::put('movements/{movement}', [MovementConfirmationController::class, 'update'])->name('movements.update');
    
    Route::get('clients', [ClientMasterController::class, 'index'])->name('clients.index');
    Route::get('clients/create', [ClientMasterController::class, 'create'])->name('clients.create');
    Route::post('clients', [ClientMasterController::class, 'store'])->name('clients.store');
    Route::get('clients/{client}', [ClientMasterController::class, 'show'])->name('clients.show');
    Route::get('clients/{client}/edit', [ClientMasterController::class, 'edit'])->name('clients.edit');
    Route::put('clients/{client}', [ClientMasterController::class, 'update'])->name('clients.update');
    Route::delete('clients/{client}', [ClientMasterController::class, 'destroy'])->name('clients.destroy');
    Route::post('delete-client-brands', [ClientMasterController::class, 'deleteBrand']);

    Route::post('amazon-progress/activate', [AmazonProgressController::class, 'activate'])->name('amazon-progress.activate');
    Route::get('amazon-progress', [AmazonProgressController::class, 'index'])->name('amazon-progress.index');
    Route::get('amazon-progress/create', [AmazonProgressController::class, 'create'])->name('amazon-progress.create');
    Route::get('amazon-progress/{id}', [AmazonProgressController::class, 'show'])->name('amazon-progress.show');
    Route::post('amazon-progress', [AmazonProgressController::class, 'store'])->name('amazon-progress.store');
    Route::get('amazon-progress/{id}/edit', [AmazonProgressController::class, 'edit'])->name('amazon-progress.edit');
    Route::delete('amazon-progress/{id}', [AmazonProgressController::class, 'destroy'])->name('amazon-progress.destroy');
    Route::get('amazon-progress-file/{id}', [AmazonProgressController::class, 'deleteFile'])->name('amazon-progress.deleteFile');
    Route::post('amazon-progress/{id}', [AmazonProgressController::class, 'update'])->name('amazon-progress.update');

    Route::post('delivers/activate', [DeliverController::class, 'activate'])->name('delivers.activate');
    Route::get('delivers', [DeliverController::class, 'index'])->name('delivers.index');
    Route::get('delivers/{deliver}', [DeliverController::class, 'show'])->name('delivers.show');
    Route::post('delivers', [DeliverController::class, 'store'])->name('delivers.store');
    Route::delete('delivers/{deliver}', [DeliverController::class, 'destroy'])->name('delivers.destroy');
    Route::put('delivers/{deliver}', [DeliverController::class, 'update'])->name('delivers.update');

    Route::get('wdata', [WarehouseDataController::class, 'index'])->name('wdata.index');
    Route::get('wdata/create', [WarehouseDataController::class, 'create'])->name('wdata.create');
    Route::post('wdata', [WarehouseDataController::class, 'store'])->name('wdata.store');
    Route::delete('wdata/{wdata}', [WarehouseDataController::class, 'destroy'])->name('wdata.destroy');
    Route::get('wdata/{wdata}', [WarehouseDataController::class, 'show'])->name('wdata.show');
    Route::get('wdata/{wdata}/edit', [WarehouseDataController::class, 'edit'])->name('wdata.edit');
    Route::post('wdata/{wdata}', [WarehouseDataController::class, 'update'])->name('wdata.update');

    Route::post('users/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('meetings', [MeetingController::class, 'list'])->name('meetings.list');
    Route::get('meetings/all', [MeetingController::class, 'meetingList'])->name('meetings.meetingList');
    Route::get('meetings/create', [MeetingController::class, 'createMeet'])->name('meetings.create');
    Route::post('meetings/create', [MeetingController::class, 'store'])->name('meetings.index');
    Route::get('meetings/{meetingId}/participants', [MeetingController::class, 'participantList'])->name('meetings.participants');
    Route::get('meetings/{id}/edit', [MeetingController::class, 'edit'])->name('meetings.edit');
    Route::post('meetings/{id}', [MeetingController::class, 'updateMeeting'])->name('meetings.update');
    Route::get('meetings/{id}/destroy', [MeetingController::class, 'destroy'])->name('meetings.destroy');


    Route::get('rooms', [ZoomRoomController::class, 'listRooms'])->name('rooms.list');
    Route::get('rooms/create', [ZoomRoomController::class, 'createRoom'])->name('rooms.create');
    Route::post('rooms', [ZoomRoomController::class, 'saveRoom'])->name('rooms.store');
    Route::get('rooms/{id}/edit', [ZoomRoomController::class, 'edit'])->name('rooms.edit');
    Route::post('rooms/{id}', [ZoomRoomController::class, 'updateRoom'])->name('rooms.update');
    Route::get('rooms/{id}/destroy', [ZoomRoomController::class, 'destroy'])->name('rooms.destroy');
    
    Route::post('wdata-categories/activate', [WdataCategoryController::class, 'activate'])->name('wdata-categories.activate');
    Route::get('wdata-categories', [WdataCategoryController::class, 'index'])->name('wdata-categories.index');
    Route::get('wdata-categories/{id}', [WdataCategoryController::class, 'show'])->name('wdata-categories.show');
    Route::post('wdata-categories', [WdataCategoryController::class, 'store'])->name('wdata-categories.store');
    Route::delete('wdata-categories/{id}', [WdataCategoryController::class, 'destroy'])->name('wdata-categories.destroy');
    Route::put('wdata-categories/{id}', [WdataCategoryController::class, 'update'])->name('wdata-categories.update');

    Route::post('carriers/activate', [CarrierController::class, 'activate'])->name('carriers.activate');
    Route::get('carriers', [CarrierController::class, 'index'])->name('carriers.index');
    Route::get('carriers/{id}', [CarrierController::class, 'show'])->name('carriers.show');
    Route::post('carriers', [CarrierController::class, 'store'])->name('carriers.store');
    Route::delete('carriers/{id}', [CarrierController::class, 'destroy'])->name('carriers.destroy');
    Route::put('carriers/{id}', [CarrierController::class, 'update'])->name('carriers.update');

    Route::get('wdata-status', [WdataStatusController::class, 'index'])->name('wdata-status.index');
    Route::get('wdata-status/{id}', [WdataStatusController::class, 'show'])->name('wdata-status.show');
    Route::post('wdata-status', [WdataStatusController::class, 'store'])->name('wdata-status.store');
    Route::delete('wdata-status/{id}', [WdataStatusController::class, 'destroy'])->name('wdata-status.destroy');
    Route::put('wdata-status/{id}', [WdataStatusController::class, 'update'])->name('wdata-status.update');

    Route::post('wdata-pics/activate', [WdataPicController::class, 'activate'])->name('wdata-pics.activate');
    Route::get('wdata-pics', [WdataPicController::class, 'index'])->name('wdata-pics.index');
    Route::get('wdata-pics/{id}', [WdataPicController::class, 'show'])->name('wdata-pics.show');
    Route::post('wdata-pics', [WdataPicController::class, 'store'])->name('wdata-pics.store');
    Route::delete('wdata-pics/{id}', [WdataPicController::class, 'destroy'])->name('wdata-pics.destroy');
    Route::put('wdata-pics/{id}', [WdataPicController::class, 'update'])->name('wdata-pics.update');

    Route::get('inbound-statuses', [InboundStatusController::class, 'index'])->name('inbound-statuses.index');
    Route::get('inbound-statuses/{id}', [InboundStatusController::class, 'show'])->name('inbound-statuses.show');
    Route::post('inbound-statuses', [InboundStatusController::class, 'store'])->name('inbound-statuses.store');
    Route::delete('inbound-statuses/{id}', [InboundStatusController::class, 'destroy'])->name('inbound-statuses.destroy');
    Route::put('inbound-statuses/{id}', [InboundStatusController::class, 'update'])->name('inbound-statuses.update');
    
});
