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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'v1'], function () {

    Route::get('/login', function () {
        return response()->json('Invalid auth', 401);
    })->name('login');
    
    Route::group(['prefix' => 'user'], function(){
    Route::post('/create', [AuthController::class, 'register']);

    Route::post('/login', [AuthController::class, 'login']);
});
    Route::group(['prefix' => 'admin'], function () {
        Route::post('/create', [AdminAuthController::class, 'register']);

        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/user', [UserController::class, 'getUserDetails']);

        Route::post('/payments/create', [PaymentController::class, 'store']);

        Route::get('/payments', [PaymentController::class, 'index']);

        // Get one payment
        Route::get('/payments/{uuid}', [PaymentController::class, 'show']);

        // Update a payment
        Route::put('/payments/{uuid}', [PaymentController::class, 'update']);

        // delete a payment
        Route::delete('/payments/{uuid}', [PaymentController::class, 'destroy']);
        // create admin routes
        Route::get('/admin/users', [UserController::class, 'users'])->middleware('isAdmin');
    });
});
