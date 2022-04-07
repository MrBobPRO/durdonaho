<?php

use App\Http\Controllers\MainController;
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

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'home')->name('home');
});

Route::get('/quotes', [MainController::class, 'home'])->name('quotes.index');
Route::get('/authors', [MainController::class, 'home'])->name('authors.index');

require __DIR__.'/auth.php';