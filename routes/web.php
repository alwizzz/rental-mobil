<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ArmadaController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingArmadaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\KeterlambatanController;

//Test
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


Route::middleware(['auth'])->group(function () {
    
    // Route::get('/', function () {
    //     return view('dashboard.index');
    // });
    
    Route::get('/', [DashboardController::class, 'index']);

    Route::resource('armada', ArmadaController::class);
    
    Route::resource('merk', MerkController::class);
    
    Route::resource('pembayaran', PembayaranController::class);
    
    Route::resource('pelanggan', PelangganController::class);
    
    Route::resource('booking', BookingController::class);
    
    Route::resource('booking_armada', BookingArmadaController::class);

    Route::resource('pengembalian', PengembalianController::class);

    Route::get('/exportpdf', [BookingController::class, 'exportpdf'])->name('exportpdf');

    Route::get('/exportpdfBooking', [BookingController::class, 'exportpdfBooking'])->name('exportpdfBooking');

    Route::get('/exportexcel', [BookingController::class, 'exportexcel'])->name('exportexcel');

});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
