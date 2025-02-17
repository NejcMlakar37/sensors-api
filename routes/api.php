<?php

use App\Http\Controllers\BatteryStatusController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmailRecipientController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\MeasurementLimitController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api-sensors')->group(function () {
    Route::post("/measurement/new", [MeasurementController::class, "store"])->name("measurement.new");
    Route::post("/battery-status/new", [BatteryStatusController::class, "store"])->name("battery-status.new");
});

Route::middleware(['throttle:30,1'])->group(function () {
    Route::post('/login', [UserController::class, 'login'])->name('user.login');
});

Route::middleware(['throttle:30,1', 'auth:api-users'])->group(function () {

    /**
     * User routes
     */
    Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
    Route::post('/change-password', [UserController::class, 'passwordChange'])->name('user.passwordChange');

    /**
     * Company routes
     */
    Route::get("/company/all", [CompanyController::class, "index"])->name("company.all");
    Route::get("/company/find/{id}", [CompanyController::class, "show"])->name("company.find");
    Route::post("/company/new", [CompanyController::class, "store"])->name("company.new");
    Route::put("/company/update/{id}", [CompanyController::class, "update"])->name('company.update');
    Route::delete("/company/{id}", [CompanyController::class, "destroy"])->name('company.destroy');

    /**
     * Sensor routes
     */
    Route::get("/sensor/all", [SensorController::class, "index"])->name("sensor.all");
    Route::get("/sensor/find/{id}", [SensorController::class, "show"])->name("sensor.find");
    Route::post("/sensor/new", [SensorController::class, "store"])->name("sensor.new");
    Route::put("/sensor/update/{id}", [SensorController::class, "update"])->name('sensor.update');
    Route::delete("/sensor/{id}", [SensorController::class, "destroy"])->name('sensor.destroy');

    /**
     * Measurement routes
     */
    Route::get("/measurement/find/{id}", [MeasurementController::class, "show"])->name("measurement.find");
    Route::get("/measurement/latest/{sensorId}", [MeasurementController::class, "getLatestMeasurement"])
        ->name("measurement.latest");
    Route::get("/measurement/index", [MeasurementController::class, "index"])
        ->name("measurement.index");
    Route::get('/measurement/export/', [MeasurementController::class, 'exportToExcel'])->name("measurement.export");
    Route::delete("/measurement/{id}", [MeasurementController::class, "destroy"])->name("measurement.destroy");

    /**
     * Battery routes
     */
    Route::get("/battery-status/all", [BatteryStatusController::class, "index"])->name("battery-status.all");
    Route::get("/battery-status/{id}", [BatteryStatusController::class, "show"])
        ->name("battery-status.find");
    Route::post("/battery-status/new", [BatteryStatusController::class, "store"])->name("battery-status.new");
    Route::delete("/battery-status/{id}", [BatteryStatusController::class, "destroy"])->name("battery-status.destroy");

    /**
     * Measurement limit routes
     */
    Route::get("/measurement-limit/all", [MeasurementLimitController::class, "index"])->name("measurement-limit.all");
    Route::get("/measurement-limit/{id}", [MeasurementLimitController::class, "show"])
        ->name("measurement-limit.find");
    Route::post("/measurement-limit/new", [MeasurementLimitController::class, "store"])->name("measurement-limit.new");
    Route::put("/measurement-limit/update", [MeasurementLimitController::class, "update"])->name("measurement-limit.update");
    Route::delete("/measurement-limit/{id}", [MeasurementLimitController::class, "destroy"])->name("measurement-limit.destroy");

    /**
     * Email recipients routes
     */
    Route::get("/recipient/all", [EmailRecipientController::class, "index"])->name("recipient.all");
    Route::get("/recipient/{id}", [EmailRecipientController::class, "show"])
        ->name("recipient.find");
    Route::post("/recipient/new", [EmailRecipientController::class, "store"])->name("recipient.new");
    Route::put("/recipient/update", [EmailRecipientController::class, "update"])->name("recipient.update");
    Route::delete("/recipient/{id}", [EmailRecipientController::class, "destroy"])->name("recipient.destroy");

    /**
     * Incident routes
     */
    Route::get("/incident/all", [IncidentController::class, "index"])->name("incident.all");
    Route::get("/incident/{id}", [IncidentController::class, "show"])
        ->name("incident.find");
});
