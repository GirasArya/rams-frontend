<?php

use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ManageAsetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminMapController;
use App\Http\Controllers\GuestMapController;
use App\Http\Controllers\LegerJalanUtamaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main Page for Guest
Route::get('/', [GuestMapController::class, 'index'])->name('index');

// Login Page
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login/api', [AuthController::class, 'login'])->name('login.api');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Map Page
Route::get('/map', [AdminMapController::class, 'index'])->name('admin.map');
Route::post('/map/download', [AdminMapController::class, 'download'])->name('admin.map.download');
// Route::get('/map/jalan_utama_belakang', [AdminMapController::class, 'jalanUtamaBelakang'])->name('admin.map.jalan_utama_belakang');
Route::post('/map/jalan_utama_all', [AdminMapController::class, 'jalanUtamaAll'])->name('admin.map.jalan_utama_all');

//Leger Jalan Utama Page
Route::get('/leger/view', [LegerJalanUtamaController::class, 'legerViewSelect'])->name('admin.leger.jalanUtama.view.select');
Route::get('/leger/edit', [LegerJalanUtamaController::class, 'legerEditSelect'])->name('admin.leger.jalanUtama.edit.select');
Route::post('/leger/view/detail', [LegerJalanUtamaController::class, 'legerViewDetail'])->name('admin.leger.jalanUtama.view.detail');
Route::post('/leger/edit/detail', [LegerJalanUtamaController::class, 'legerEditDetail'])->name('admin.leger.jalanUtama.edit.detail');
Route::post('/leger/generate', [LegerJalanUtamaController::class, 'legerGenerate'])->name('admin.leger.jalanUtama.generate');
Route::post('/leger/print', [LegerJalanUtamaController::class, 'legerPrint'])->name('admin.leger.jalanUtama.print');


// Input Page
Route::get('/input/ruas', [InputController::class, 'ruas'])->name('input.ruas');
Route::post('/input/ruas/store', [InputController::class, 'storeRuas'])->name('input.ruas.store');
Route::get('/input/aset', [InputController::class, 'aset'])->name('input.aset');
Route::post('/input/aset/store', [InputController::class, 'storeAset'])->name('input.aset.store');



//Maintenance Page
Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('admin.maintenance');
Route::get('/maintenance/activity', [MaintenanceController::class, 'maintenanceActivity'])->name('admin.maintenance.activity');
Route::post('/maintenance/store', [MaintenanceController::class, 'storeMaintenanceRecord'])->name('admin.maintenance.store');
Route::post('/maintenance/print', [MaintenanceController::class, 'exportRecord'])->name('admin.maintenance.print');


//Manage aset list
Route::get('/manage-aset', [ManageAsetController::class, 'index'])->name('admin.manage_aset'); //dahsboard manage aset
Route::get('/input/aset-temp', [ManageAsetController::class, 'inputAsetTemp'])->name('input.aset-temp'); //input manage aset
Route::post('input/aset/store/new', [ManageAsetController::class, 'storeAssetRecord'])->name('admin.asset.store');
Route::post('input/aset/store/filter', [ManageAsetController::class, 'storeAssetRecord'])->name('admin.asset.filter');