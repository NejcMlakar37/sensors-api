<?php

use App\Http\Controllers\EmailRecipientController;
use App\Http\Controllers\MeasurementLimitController;
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

    /**
     * Sensors routes
     */
    Route::prefix('sensors')->name('sensors.')->group(function () {
        Route::get('/{id}', [SensorController::class, 'show'])->name('index');
        Route::get('/full-screen/{id}', [SensorController::class, 'fullScreen'])->name("fullScreen");
    });

    /**
     * Email recipients routes
     */
    Route::prefix('recipient')->name('recipient.')->group(function () {
        Route::post("", [EmailRecipientController::class, "store"])->name("recipient.create");
        Route::put("/{id}", [EmailRecipientController::class, "update"])->name("recipient.update");
        Route::delete("/{id}", [EmailRecipientController::class, "destroy"])->name("recipient.destroy");
    });

    /**
     * Measurement limit routes
     */
    Route::prefix('measurement-limit')->name('measurement-limit.')->group(function () {
        Route::post("", [MeasurementLimitController::class, "store"])->name("new");
        Route::put("/{id}", [MeasurementLimitController::class, "update"])->name("update");
        Route::delete("/{id}", [MeasurementLimitController::class, "destroy"])->name("destroy");
    });
});
