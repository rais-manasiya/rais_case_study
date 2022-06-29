<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

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

//API route for register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);

// Rate-limit assigned to 3 attempt per minute 
Route::middleware(['throttle:api'])->group(function () {
//API route for login user
Route::post('/auth/login', [App\Http\Controllers\API\AuthController::class, 'login']);
});

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //API routes for cart CRUD
    Route::resource('cart', CartController::class);

    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});

//API routes for product CRUD
Route::resource('products', ProductController::class);
Route::middleware('throttle:60,1')->get('/user', function () {
    //
});