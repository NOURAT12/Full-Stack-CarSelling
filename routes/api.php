<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\User\DesignController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin/')->controller(AdminController::class)->group(function () {
    Route::post('createUserAccount', 'createUserAccount');
    // Route::get('refresh', 'refresh');
    // Route::get('logout', 'logout');
    // Route::post('verifyOtp', 'verifyOtp');
    // Route::post('sendOtp', 'sendOtp');
    // Route::post('resetPassword', 'resetPassword');
});

Route::prefix('user/')->controller(UserController::class)->group(function () {
    Route::post('login', 'login');
    Route::get('logout', 'logout');
    Route::post('company', 'addCompanyInfo');
    Route::post('updatecompany', 'updateCompany');
    Route::delete('company', 'deleteCompany');
    Route::get('company', 'displayCompanyInfo');
});

Route::prefix('user/')->controller(ProductController::class)->group(function () {
    Route::post('product', 'createProduct');
    Route::post('updateproduct', 'updateProduct');
    Route::delete('product', 'deleteproduct');
    Route::get('product', 'displayProducts');
});

Route::prefix('user/')->controller(DesignController::class)->group(function () {
    Route::post('design', 'createDesign');
    Route::post('updatedesign', 'updateDesign');
    Route::delete('design', 'deleteDesign');
    Route::get('design', 'displayDesign');
    Route::get('designs', 'displayDesigns');
});

