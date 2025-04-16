<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\general\BrokerController;
use App\Http\Controllers\Admin\UserManagmentController;

// // Translation
Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang');

// Auth
Route::get('/', [AuthController::class, 'loginPage'])->name('login-page');
 
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register-page', [AuthController::class, 'registerPage'])->name('register-page');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
// Dashboard

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// User Managment
Route::group(['prefix' => 'user_management'], function () {

    Route::get('/', [UserManagmentController::class, 'index'])->name('admin.user_managment');
    Route::get('/create', [UserManagmentController::class , 'create'])->name('admin.user_managment.create');
    Route::post('/create', [UserManagmentController::class , 'store'])->name('admin.user_managment.store');
    Route::get('/edit/{id}' , [UserManagmentController::class , 'edit'])->name('admin.user_managment.edit');
    Route::patch('/update/{id}' , [UserManagmentController::class , 'update'])->name('admin.user_managment.update');
    Route::get('/delete/{id}', [UserManagmentController::class ,'destroy'])->name('admin.user_managment.delete');

    Route::get('/signature', [UserManagmentController::class, 'signature'])->name('admin.user_management.signature');

});

// Broker Managment
Route::group(['prefix' => 'broker'], function () {

    Route::get('/', [BrokerController::class, 'index'])->name('admin.broker');
    Route::get('/create', [BrokerController::class , 'create'])->name('admin.broker.create');
    Route::post('/create', [BrokerController::class , 'store'])->name('admin.broker.store');
    Route::get('/edit/{id}' , [BrokerController::class , 'edit'])->name('admin.broker.edit');
    Route::patch('/update/{id}' , [BrokerController::class , 'update'])->name('admin.broker.update');
    Route::get('/delete/{id}', [BrokerController::class ,'destroy'])->name('admin.broker.delete');

   
});

// Roles
Route::group(['prefix' => 'admin/roles'], function () {
    Route::get('/', [RoleController::class, 'index'])->name('admin.roles');
    Route::get('/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/store', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::post('/{id}/update', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/delete', [RoleController::class, 'destroy'])->name('admin.roles.delete');
});

// Settings

Route::group(['prefix' => 'settings'], function () {

    Route::get('/', [SettingsController::class, 'index'])->name('admin.settings');
    Route::get('/edit/{setting}', [SettingsController::class, 'edit'])->name('admin.settings.edit');
    Route::put('/update/{setting}', [SettingsController::class, 'update'])->name('admin.settings.update');
});

 