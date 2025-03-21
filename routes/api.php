<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilesController;

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

/* files */

Route::post('/files/upload', [FilesController::class, 'uploadFiles']);
Route::get('/files/get', [FilesController::class, 'getFilesList'])->middleware('auth');

/* auth */

Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth/registration', [AuthController::class, 'registration']);
Route::get('/auth/check', [AuthController::class, 'check']);
