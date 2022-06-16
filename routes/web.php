<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MoneyConvertController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/submit', [HomeController::class, 'submit'])->name('submit');
Route::get('/money-convert', [MoneyConvertController::class, 'index'])->name('money-convert');
Route::get('/result', [MoneyConvertController::class, 'result'])->name('result');
Route::get('/history', [MoneyConvertController::class, 'history'])->name('history');
Route::get('/mail', [MoneyConvertController::class, 'mail'])->name('mail');
