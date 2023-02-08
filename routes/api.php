<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/contacts/{uid?}', [ContactController::class, 'index'])->where('uid', '[0-9]+')->middleware('auth');

Route::get('/groups/{all?}', [GroupController::class, 'index'])->where('all', '[0,1]+')->middleware('auth');

Route::get('/subscribers/{gid?}', [SubscriberController::class, 'index'])->where('gid', '[0-9]+')->middleware('auth');

Route::get('/types', [TypeController::class, 'index'])->middleware('auth');

Route::get('/intypes', [TypeController::class, 'show'])->middleware('auth');
