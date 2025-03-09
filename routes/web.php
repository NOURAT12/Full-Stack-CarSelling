<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Resources\ProductResource;
use App\Models\Car;
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

Route::get('/', function () {
    return Inertia::render('Welcome',[
        'status' => session('status'),
    ]);
});

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::controller(AuthenticatedSessionController::class)->group(function () {
//     Route::post('login', 'store')->name('login');
//     Route::post('logout', 'logout')->name('logout');
// });

Route::resource( '/cars',AdminController::class);


// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// });

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', function () {
        $cars = ProductResource::collection(Car::all());
        return Inertia::render('Dashboard',compact('cars'));
    })->name('dashboard');
});


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

