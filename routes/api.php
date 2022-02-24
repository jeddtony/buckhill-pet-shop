<?php

use App\Http\Controllers\API\AdminAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;

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


Route::group(['prefix' => 'v1'], function () {

    Route::get('/login', function () {
        return response()->json('Invalid auth', 401);
    })->name('login');
    

    Route::post('/create', [AuthController::class, 'register']);

    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['prefix' => 'admin'], function () {
        Route::post('/create', [AdminAuthController::class, 'register']);

        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/user', [UserController::class, 'getUserDetails']);

        Route::post('/payment', [PaymentController::class, 'store']);
    });
});
