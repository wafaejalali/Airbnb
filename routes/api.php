<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
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
Route::controller(UserController::class)->group(function () {
    Route::post('/adminLogin','login');
    Route::get('/admins', 'index');
    Route::post('/admin','store');
});
Route::controller(MessageController::class)->group(function () {
    Route::post('/participant','getParticipants');
    Route::post('/messages','getMessages');
    Route::post('/sendMessages','store');

});
