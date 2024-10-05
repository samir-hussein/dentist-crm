<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PatientController;

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

Route::middleware("guest")->controller(AuthController::class)->group(function () {
    Route::post("/login", "login")->name('login.submit');
    Route::get("/", "index")->name("login");
});

Route::middleware("auth")->group(function () {
    Route::get("/logout", [AuthController::class, "logout"])->name('logout');

    Route::get("/home", [HomePageController::class, "index"])->name('home');

    Route::resource('admins', UserController::class)->missing(function () {
        return abort(404);
    });

    Route::resource('staff', UserController::class)->missing(function () {
        return abort(404);
    });

    Route::resource('doctors', DoctorController::class)->missing(function () {
        return abort(404);
    });

    Route::get("patients/all", [PatientController::class, 'all'])->name('patients.all');
    Route::resource('patients', PatientController::class)->missing(function () {
        return abort(404);
    });
});
