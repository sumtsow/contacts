<?php

namespace App\Http\Controllers;

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

Route::view('/', 'index')->middleware('auth');

Route::get('/welcome', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::post('/contact/{id}', [ContactController::class, 'store'])->where('id', '[0-9]+')->middleware('auth');

Route::post('/group/{id}', [GroupController::class, 'store'])->where('id', '[0-9]+')->middleware('auth');

Route::post('/subscriber/{id}', [SubscriberController::class, 'store'])->where('id', '[0-9]+')->middleware('auth');

Route::post('/type/{id}', [TypeController::class, 'store'])->where('id', '[0-9]+')->middleware('auth');

require __DIR__.'/auth.php';
