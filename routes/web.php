<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthenticationController::class)->group(function () {
    Route::post('register', 'register')->middleware('guest');
    Route::post('login', 'login')->middleware('guest');
    Route::post('logout', 'logout')->middleware('auth')->name('logout');
});

Route::controller(VerifyEmailController::class)->name('verification.')->group(function () {
    Route::get('verify-email', 'notice')->name('notice');
    Route::get('verify-user/{token}', 'verify')->name('verify');
    Route::post('resend-email', 'resendEmail')->name('resend.email');
});

Route::controller(PasswordResetController::class)->name('password.')->group(function () {
    Route::post('forgot-password', 'mail')->name('forgot.mail');
    Route::get('reset-password/{token}', 'show')->name('reset.show');
    Route::post('reset-password', 'update')->name('reset.update');
});

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'home')->name('home');
});

Route::controller(QuoteController::class)->prefix('quotes')->name('quotes.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/individual', 'individual')->name('individual');
    Route::get('/top', 'top')->name('top');

    Route::post('/ajax-get', 'ajaxGet')->name('ajax.get');
});

Route::controller(AuthorController::class)->prefix('authors')->name('authors.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/individual', 'individual')->name('individual');
    Route::get('/{slug}', 'show')->name('show');

    Route::post('/ajax-get', 'ajaxGet')->name('ajax.get');
});