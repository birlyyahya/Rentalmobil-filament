<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ManageBooking;
use App\Http\Controllers\PembayaranController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Passwords\Confirm;
use App\Livewire\Auth\Passwords\Email;
use App\Livewire\Auth\Passwords\Reset;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Verify;
use App\Livewire\Reservasi;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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

Route::view('/', 'welcome')->name('home');


Route::middleware('guest')->group(function () {
    // Route::get('login', Login::class)
    //     ->name('login');

    Route::get('register', Register::class)
        ->name('register');
});



Route::controller(KatalogController::class)->group(function () {
    Route::get('/search', 'index')->name('search');
    Route::get('/katalog/{id}/{tanggalAmbil}/{tanggalKembali}/{waktu}', 'show')->name('katalog.show');
});

Route::get('reservasi', Reservasi::class)->name('reservasi');

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');
});
Route::post('logout', LogoutController::class)
    ->name('logout');

Route::controller(PembayaranController::class)->group(function () {
    Route::post('/', 'index')->name('index');
    Route::get('/invoice-{invoice}', 'show')->name('invoice.show');
    Route::post('/midtrans/callback', 'store')->name('midtrans.store');
    Route::post('/refund', 'refund')->name('refund');
});
Route::group(['middleware' => 'web'], function () {
    Route::controller(ManageBooking::class)->group(function () {
        Route::get('/manage-booking', 'index')->name('managebooking');
        Route::post('/checkingbooking', 'store')->name('managebooking.store');
        Route::get('/pdf/invoice-{kode_transaksi}', 'generatePDF')->name('generatePDF');
    });
});
