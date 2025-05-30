<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\general\HotelController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\general\BrokerController;
use App\Http\Controllers\general\DriverController;
use App\Http\Controllers\booking\BookingController;
use App\Http\Controllers\general\ServiceController;
use App\Http\Controllers\general\CustomerController;
use App\Http\Controllers\general\UnitTypeController;
use App\Http\Controllers\Admin\UserManagmentController;
use App\Http\Controllers\CancelController;
use App\Http\Controllers\CarCategoryController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CustFileController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoactionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TourController;
use PHPUnit\TextUI\Configuration\FileCollection;

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
Route::get('/dashboard/charts', [DashboardController::class, 'bookingCharts'])->name('dashboard.charts');
Route::prefix('car-dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'car_index'])->name('car.dashboard');
    Route::get('/charts', [DashboardController::class, 'carCharts'])->name('car.dashboard.charts');
});
// User Managment
Route::group(['prefix' => 'user_management'], function () {

    Route::get('/', [UserManagmentController::class, 'index'])->name('admin.user_managment');
    Route::get('/create', [UserManagmentController::class, 'create'])->name('admin.user_managment.create');
    Route::post('/create', [UserManagmentController::class, 'store'])->name('admin.user_managment.store');
    Route::get('/edit/{id}', [UserManagmentController::class, 'edit'])->name('admin.user_managment.edit');
    Route::patch('/update/{id}', [UserManagmentController::class, 'update'])->name('admin.user_managment.update');
    Route::get('/delete/{id}', [UserManagmentController::class, 'destroy'])->name('admin.user_managment.delete');

    Route::get('/signature', [UserManagmentController::class, 'signature'])->name('admin.user_management.signature');
});

// Broker Managment
Route::group(['prefix' => 'broker'], function () {

    // Route::get('/', [BrokerController::class, 'index'])->name('admin.broker');
    Route::get('/create', [BrokerController::class, 'create'])->name('admin.broker.create');
    Route::post('/create', [BrokerController::class, 'store'])->name('admin.broker.store');
    Route::get('/edit/{id}', [BrokerController::class, 'edit'])->name('admin.broker.edit');
    Route::patch('/update/{id}', [BrokerController::class, 'update'])->name('admin.broker.update');
    Route::get('/delete/{id}', [BrokerController::class, 'destroy'])->name('admin.broker.delete');
});

// Customer Managment
Route::group(['prefix' => 'customer'], function () {

    Route::get('/', [CustomerController::class, 'index'])->name('admin.customer');
    Route::get('/create', [CustomerController::class, 'create'])->name('admin.customer.create');
    Route::post('/create', [CustomerController::class, 'store'])->name('admin.customer.store');
    Route::post('/store_for_any', [CustomerController::class, 'store_for_any'])->name('admin.customer.store_for_any');
    Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('admin.customer.edit');
    Route::patch('/update/{id}', [CustomerController::class, 'update'])->name('admin.customer.update');
    Route::get('/delete/{id}', [CustomerController::class, 'destroy'])->name('admin.customer.delete');
    Route::get('/show/{id}', [CustomerController::class, 'show'])->name('admin.customer.show');
    Route::get('/file/{id}', [CustomerController::class, 'show_file'])->name('admin.show.file');
});

// UnitType Managment
Route::group(['prefix' => 'unit_type'], function () {

    Route::get('/', [UnitTypeController::class, 'index'])->name('admin.unit_type');
    Route::get('/create', [UnitTypeController::class, 'create'])->name('admin.unit_type.create');
    Route::post('/create', [UnitTypeController::class, 'store'])->name('admin.unit_type.store');
    Route::get('/edit/{id}', [UnitTypeController::class, 'edit'])->name('admin.unit_type.edit');
    Route::patch('/update/{id}', [UnitTypeController::class, 'update'])->name('admin.unit_type.update');
    Route::get('/delete/{id}', [UnitTypeController::class, 'destroy'])->name('admin.unit_type.delete');
});

// Hotel Managment
Route::group(['prefix' => 'hotel'], function () {

    Route::get('/', [HotelController::class, 'index'])->name('admin.hotel');
    Route::get('/create', [HotelController::class, 'create'])->name('admin.hotel.create');
    Route::post('/create', [HotelController::class, 'store'])->name('admin.hotel.store');
    Route::get('/edit/{id}', [HotelController::class, 'edit'])->name('admin.hotel.edit');
    Route::patch('/update/{id}', [HotelController::class, 'update'])->name('admin.hotel.update');
    Route::get('/delete/{id}', [HotelController::class, 'destroy'])->name('admin.hotel.delete');
    Route::post('/store_for_any', [HotelController::class, 'store_for_any'])->name('admin.hotel.store_for_any');
});

// Driver Managment
Route::group(['prefix' => 'driver'], function () {

    Route::get('/', [DriverController::class, 'index'])->name('admin.driver');
    Route::get('/create', [DriverController::class, 'create'])->name('admin.driver.create');
    Route::post('/create', [DriverController::class, 'store'])->name('admin.driver.store');
    Route::get('/edit/{id}', [DriverController::class, 'edit'])->name('admin.driver.edit');
    Route::patch('/update/{id}', [DriverController::class, 'update'])->name('admin.driver.update');
    Route::get('/delete/{id}', [DriverController::class, 'destroy'])->name('admin.driver.delete');
});

// Service Managment
Route::group(['prefix' => 'service'], function () {

    Route::get('/', [ServiceController::class, 'index'])->name('admin.service');
    Route::get('/create', [ServiceController::class, 'create'])->name('admin.service.create');
    Route::post('/create', [ServiceController::class, 'store'])->name('admin.service.store');
    Route::post('/create/booking', [ServiceController::class, 'store_for_any'])->name('admin.service.store_any');
    Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('admin.service.edit');
    Route::patch('/update/{id}', [ServiceController::class, 'update'])->name('admin.service.update');
    Route::get('/delete/{id}', [ServiceController::class, 'destroy'])->name('admin.service.delete');
});

// Booking Managment
Route::group(['prefix' => 'booking'], function () {

    Route::get('/', [BookingController::class, 'index'])->name('admin.booking');
    Route::get('/coming_soon', [BookingController::class, 'coming_soon'])->name('admin.booking.coming_soon');
    Route::get('/live_booking', [BookingController::class, 'live_booking'])->name('admin.booking.live_booking');
    Route::get('/create', [BookingController::class, 'create'])->name('admin.booking.create');
    Route::post('/create', [BookingController::class, 'store'])->name('admin.booking.store');
    Route::get('/edit/{id}', [BookingController::class, 'edit'])->name('admin.booking.edit');
    Route::get('/show/{id}', [BookingController::class, 'show'])->name('admin.booking.show');
    Route::patch('/update/{id}', [BookingController::class, 'update'])->name('admin.booking.update');
    Route::get('/cancel/{id}', [BookingController::class, 'cancel'])->name('admin.booking.cancel');
    Route::get('/delete/{id}', [BookingController::class, 'destroy'])->name('admin.booking.delete');


    Route::get('/get_country/{id}', [BookingController::class, 'get_country'])->name('booking.get_country');
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

Route::resource('meal', MealController::class);
Route::resource('cancel', CancelController::class);
Route::get('/get-cities/{country}', [LocationController::class, 'getCities']);
Route::get('/booking/{id}/voucher-pdf', [BookingController::class, 'generateVoucherPdf'])->name('booking.voucher.pdf');
Route::resource('car', CarController::class);
Route::get('/get-category-price/{id}', [CarController::class, 'getCategoryPrice']);
Route::resource('category', CarCategoryController::class);
Route::resource('tour', TourController::class);
Route::put('/car/{id}/status', [CarController::class, 'updateStatus'])
    ->name('car.updateStatus');


Route::post('bookings/bulk_action', [BookingController::class, 'bulkAction'])
    ->name('admin.booking.bulk_action');
Route::get('bookings/reports', [BookingController::class, 'reports'])
    ->name('admin.booking.reports');
Route::put('/booking/{id}/status', [BookingController::class, 'bookingupdateStatus'])
    ->name('booking.updateStatus');

Route::post('/create/meal', [MealController::class, 'store_for_any'])->name('admin.meal.store_any');
Route::post('/create/cancel', [CancelController::class, 'store_for_any'])->name('admin.cancel.store_any');

Route::group(['prefix' => 'file'], function () {

    Route::get('/create', [CustFileController::class, 'create_file'])->name('admin.file.create');
    Route::get('/index/file/{id}', [CustFileController::class, 'show_file'])->name('add.items.file');
    // Route::post('/index/file', [CustFileController::class, 'index_file'])->name('file');
    Route::post('/store', [CustFileController::class, 'store'])->name('store.file.items');
    Route::post('/store/file', [CustFileController::class, 'store_file'])->name('admin.store.file');
    //    Route::get('/show/{$id}', [CustFileController::class, 'show'])->name('admin.show.file');
    Route::put('/update/{setting}', [CustFileController::class, 'update'])->name('admin.settings.update');
    Route::get('/show/allfiles/', [CustFileController::class, 'show_all'])->name('show.all.file');
});
Route::get('users/export/', [ReportController::class, 'export'])->name('monthly.report');
Route::get('house/export/', [ReportController::class, 'MonthlyHouse'])->name('monthly.house.report');
Route::get('comission/export/', [ReportController::class, 'ComissionExport'])->name('monthly.comission.report');
Route::get('Accounting/export/', [ReportController::class, 'AccountingExport'])->name('monthly.Accounting.report');
Route::get('broker/export/', [ReportController::class, 'BrokergExport'])->name('monthly.broker.report');
Route::get('coming/export/', [ReportController::class, 'ComingSoonExport'])->name('monthly.comming.report');
Route::get('payment/export/', [ReportController::class, 'PaymentExport'])->name('monthly.payment.report');


Route::post('cust_files/{file}/payments', [PaymentController::class, 'store'])->name('payments.store');
Route::delete('payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
Route::prefix('reports')->group(function () {
    Route::get('broker', [ReportController::class, 'index'])->name('reports.broker');
    Route::get('broker/filter', [ReportController::class, 'filter'])->name('reports.broker.filter');
    Route::get('broker/export', [ReportController::class, 'BrokergExport'])->name('reports.broker.export');
});
Route::get('cars/export', [ReportController::class, 'export'])->name('car.export');
Route::get('bookings/export', [ReportController::class, 'MonthlyHouse'])->name('booking.export');
