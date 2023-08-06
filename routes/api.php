<?php

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('signup', [RegisterController::class, 'signup']);
Route::post('signin', [RegisterController::class, 'signin']);
Route::middleware('auth:api')->any('/stocks', [StockController::class, 'list']);
Route::middleware('auth:api')->post('/save-stocks', [StockController::class, 'save']);
Route::middleware('auth:api')->any('/delete-stocks', [StockController::class, 'delete']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


