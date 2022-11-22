<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MenuController;

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

Route::post('/user/CreateUser', [UsersController::class, 'store']);
Route::post('/user/login', [UsersController::class, 'login']);
Route::get('/getmenu', [MenuController::class, 'getmenu']);
ini_set('memory_limit', -1);