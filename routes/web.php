<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;

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

    Route::get("admins/all", [AdminController::class, 'all'])->name('admins.all');
    Route::resource('admins', AdminController::class)->missing(function () {
        return abort(404);
    })->only(['index', 'create', 'store', 'destroy']);

    Route::get("staff/all", [StaffController::class, 'all'])->name('staff.all');
    Route::resource('staff', StaffController::class)->missing(function () {
        return abort(404);
    })->only(['index', 'create', 'store', 'destroy']);

    Route::resource('doctors', DoctorController::class)->missing(function () {
        return abort(404);
    });

    Route::get("patients/all", [PatientController::class, 'all'])->name('patients.all');
    Route::get("patients/{patient}/profile", [PatientController::class, 'profile'])->name('patients.profile');
    Route::resource('patients', PatientController::class)->missing(function () {
        return abort(404);
    });

    Route::get("diagnosis/all", [DiagnosisController::class, 'all'])->name('diagnosis.all');
    Route::resource('diagnosis', DiagnosisController::class)->missing(function () {
        return abort(404);
    });

    Route::get("services/all", [ServiceController::class, 'all'])->name('services.all');
    Route::resource('services', ServiceController::class)->missing(function () {
        return abort(404);
    });

    Route::get("labs/all", [LabController::class, 'all'])->name('labs.all');
    Route::resource('labs', LabController::class)->missing(function () {
        return abort(404);
    });

    Route::get("appointments/all", [AppointmentController::class, 'all'])->name('appointments.all');
    Route::get("appointments/{appointment}/completed", [AppointmentController::class, 'markCompleted'])->name('appointments.markCompleted');
    Route::resource('appointments', AppointmentController::class)->missing(function () {
        return abort(404);
    });

    Route::delete("user/image", [UserController::class, "deleteProfileImage"])->name('user.image.delete');
    Route::put("user/profile", [UserController::class, "update"])->name('user.profile.update');
    Route::get("user/profile", [UserController::class, "profile"])->name('user.profile');
});
