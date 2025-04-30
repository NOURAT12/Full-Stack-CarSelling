<?php

use App\Http\Controllers\Admin\AdvertisementsController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Resources\ProductResource;
use App\Models\Car;
use App\Models\setting;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [WelcomeController::class, 'index'])->name('welcome');


// Route::resource( '/cars',AdminController::class);

Route::middleware(['auth','verified','seller'])->prefix('seller')->group(function(){
    Route::get('/dashboard',[WelcomeController::class, 'sellerDash'])->name('sellerdashboard');
    Route::resource( '/cars',controller: SellerController::class);
    Route::post('seller/cars/{car}', [SellerController::class, 'update'])->name('cars.update');
    Route::get( '/reviews',[SellerController::class, 'indexReviews'])->name('reviewsIndex');

});

Route::middleware(['auth','verified','admin'])->prefix('admin')->group(function(){
    Route::get('/dashboard',[WelcomeController::class, 'adminDash'])->name('admindashboard');
    Route::resource( '/advertisements',AdvertisementsController::class);
    Route::post('/advertisements/{advertisement}', [AdvertisementsController::class, 'update'])->name('advertisements.update');
    Route::resource( '/reviews',ReviewsController::class);
    Route::post('/reviews/{id}/status', [ReviewsController::class, 'updateStatus'])->name('reviews.status');
    Route::resource( '/settings',SettingsController::class);
    Route::post('/settings/{settings}', [SettingsController::class, 'update'])->name('settings.update');
});

Route::get('/home',[UserController::class, 'homeUser'])->name('userhome');
Route::resource( '/reviews',ReviewsController::class);
Route::resource( '/cars', SellerController::class);
Route::post('seller/cars/{car}', [SellerController::class, 'update'])->name('cars.update');
Route::post('/ads/{id}/increment-hit', [UserController::class, 'incrementHit'])->name('ads.incrementHit');
Route::get('/search-results', [UserController::class, 'results'])->name('search.results');
Route::post('/user-reviews', [UserController::class, 'create_reviews'])->name('user.reviews');



// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

