<?php

use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

// Hacer login
Route::post("/login", [UserController::class, 'autenticate']);
Route::put("/hash/{id}", [ UserController::class, 'hashPassword']);

// CRUD operations
Route::resource("/enterprise", EnterpriseController::class)->except(["create", "edit"]);
Route::resource("/product", ProductController::class)->except(["create", "edit"]);