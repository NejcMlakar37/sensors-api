<?php

use App\Http\Controllers\SensorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return inertia('LoginView');
});

Route::post("/login", [UserController::class, 'login'])->name("login");

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get("/", [UserController::class, 'homePage'])->name("home");

    Route::prefix('sensors')->name('sensors.')->group(function () {
        Route::get('/{id}', [SensorController::class, 'show'])->name('index');
        Route::get('/full-screen/{id}', [SensorController::class, 'fullScreen'])->name("fullScreen");
    });
});
