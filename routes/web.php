<?php

use App\Models\Patient;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\LabOrderController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\LabServiceController;
use App\Http\Controllers\SchduleDayController;
use App\Models\TreatmentSectionAttributeInput;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SchduleDateController;
use App\Http\Controllers\MedicineTypeController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\TreatmentTypeController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\SchduleDateTimeController;
use App\Http\Controllers\TreatmentSessionController;
use App\Http\Controllers\SubscribeNotificationController;

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

    Route::post("subscribe-notification", [SubscribeNotificationController::class, 'subscribe']);

    Route::get("/home", [HomePageController::class, "index"])->name('home');

    Route::get("patients/all", [PatientController::class, 'all'])->name('patients.all');
    Route::get("patients/{patient}/profile", [PatientController::class, 'profile'])->name('patients.file');
    Route::resource('patients', PatientController::class)->missing(function () {
        return abort(404);
    });

    Route::get("appointments/{appointment}/next", [AppointmentController::class, 'next'])->name("appointments.next");
    Route::post("appointments/{appointment}/next", [AppointmentController::class, 'nextStore'])->name("appointments.next.store");
    Route::resource('appointments', AppointmentController::class)->missing(function () {
        return abort(404);
    });

    Route::delete("user/image", [UserController::class, "deleteProfileImage"])->name('user.image.delete');
    Route::put("user/profile", [UserController::class, "update"])->name('user.profile.update');
    Route::get("user/profile", [UserController::class, "profile"])->name('user.profile');

    Route::get("treatment-session", [TreatmentSessionController::class, 'getAll'])->name("treatment.session.getAll");
    Route::get("lab-orders/all", [LabOrderController::class, 'all'])->name("lab-orders.all");
    Route::put("lab-orders/{lab_order}", [LabOrderController::class, 'update'])->name("lab-orders.update");

    Route::get("schdule-date-times/doctors/{branchId}/{dayId}", [SchduleDateTimeController::class, 'doctorList'])->name("schdule.date.time.doctors");
    Route::get("schdule-date-times/dates/{branchId}/{doctorId}", [SchduleDateTimeController::class, 'datesList'])->name("schdule.date.time.dates");
    Route::get("schdule-date-times/times/{branchId}/{doctorId}/{dateId}", [SchduleDateTimeController::class, 'timeList'])->name("schdule.date.time.times");

    Route::middleware("notStaff")->group(function () {

        Route::middleware("admin")->group(function () {
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

            Route::get("/settings", function () {
                return view('settings', ["currentRouteName" => Route::currentRouteName()]);
            })->name('settings');

            Route::get("/settings/lab", function () {
                return view('lab-settings', ["currentRouteName" => Route::currentRouteName()]);
            })->name('settings.lab-settings');

            Route::get("/settings/medicine", function () {
                return view('medicine-settings', ["currentRouteName" => Route::currentRouteName()]);
            })->name('settings.medicine-settings');

            Route::get("/settings/schdule", function () {
                return view('schdule-settings', ["currentRouteName" => Route::currentRouteName()]);
            })->name('settings.schdule-settings');

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

            Route::get("branches/all", [BranchController::class, 'all'])->name('branches.all');
            Route::resource('branches', BranchController::class)->missing(function () {
                return abort(404);
            });

            Route::get("schdule-days/all", [SchduleDayController::class, 'all'])->name('schdule-days.all');
            Route::resource('schdule-days', SchduleDayController::class)->missing(function () {
                return abort(404);
            });

            Route::get("schdule-dates/all", [SchduleDateController::class, 'all'])->name('schdule-dates.all');
            Route::get("schdule-dates/{schdule_date}/make-holiday", [SchduleDateController::class, 'makeHoliday'])->name('schdule-dates.make-holiday');
            Route::resource('schdule-dates', SchduleDateController::class)->missing(function () {
                return abort(404);
            })->except(['destroy']);
            Route::resource('times', SchduleDateController::class)->missing(function () {
                return abort(404);
            })->only(['destroy', 'update']);

            Route::get("doses/all", [DoseController::class, 'all'])->name('doses.all');
            Route::resource('doses', DoseController::class)->missing(function () {
                return abort(404);
            });

            Route::get("medical-histories/all", [MedicalHistoryController::class, 'all'])->name('medical-histories.all');
            Route::resource('medical-histories', MedicalHistoryController::class)->missing(function () {
                return abort(404);
            });

            Route::get("medicine-types/all", [MedicineTypeController::class, 'all'])->name('medicine-types.all');
            Route::resource('medicine-types', MedicineTypeController::class)->missing(function () {
                return abort(404);
            });

            Route::get("medicines/all", [MedicineController::class, 'all'])->name('medicines.all');
            Route::resource('medicines', MedicineController::class)->missing(function () {
                return abort(404);
            });

            Route::get("lab-services/all", [LabServiceController::class, 'all'])->name('lab-services.all');
            Route::resource('lab-services', LabServiceController::class)->missing(function () {
                return abort(404);
            });

            Route::get("treatment-types/all", [TreatmentTypeController::class, 'all'])->name('treatment-types.all');
            Route::resource('treatment-types', TreatmentTypeController::class)->missing(function () {
                return abort(404);
            });
        });

        Route::get("prescription", [PrescriptionController::class, 'index'])->name('prescription.index');

        Route::get("appointments/{appointment}/completed", [AppointmentController::class, 'markCompleted'])->name('appointments.markCompleted');

        Route::get("appointments/{patient}/treatment-session", [TreatmentSessionController::class, 'index'])->name('appointments.treatment');
        Route::get("treatment-tabs", [TreatmentSessionController::class, 'getTreatmentTabs'])->name('treatment.tabs');
        Route::get("patient/{patient}/tooth-panorama/{tooth_number}", [TreatmentSessionController::class, 'getToothPanorama'])->name('tooth.panorama');
        Route::post("panorama/{patient}/upload-files", [TreatmentSessionController::class, 'panoramaUploadFiles'])->name('panorama.uploadFiles');
        Route::delete("panorama/{patient}/{id}", [TreatmentSessionController::class, 'panoramaDelete'])->name('panorama.delete');
        Route::post("tooth/{patient}/upload-files/{toothNumber}", [TreatmentSessionController::class, 'toothUploadFiles'])->name('tooth.uploadFiles');
        Route::delete("tooth/{patient}/{id}/{toothNumber}", [TreatmentSessionController::class, 'toothDelete'])->name('tooth.delete');
        Route::post("treatment-session/{patient}", [TreatmentSessionController::class, 'storeTreatmentSession'])->name("treatment.session.store");
        Route::get("treatment-session/{treatment_detail}/{patient}", [TreatmentSessionController::class, 'edit'])->name("treatment.session.edit");
        Route::put("treatment-session/{treatment_detail}/{patient}", [TreatmentSessionController::class, 'update'])->name("treatment.session.update");

        Route::get("invoices/all", [InvoiceController::class, 'all'])->name("invoices.all");
        Route::get("invoices/report", [InvoiceController::class, 'report'])->name("invoices.report");
        Route::get("invoices/tax", [InvoiceController::class, 'tax'])->name("invoices.tax");
        Route::get("invoices", [InvoiceController::class, 'index'])->name("invoices.index");
        Route::get("invoices/report/tax", [InvoiceController::class, 'taxReport'])->name("invoices.tax.index");
        Route::delete("invoices/{invoice}", [InvoiceController::class, 'removeFromTax'])->name("invoices.destroy");
        Route::get("invoices/print", [InvoiceController::class, 'print'])->name("invoices.print");

        Route::get("lab-order/report", [LabOrderController::class, 'reportView'])->name('lab-order.report.view');
        Route::get("lab-order/report/data", [LabOrderController::class, 'report'])->name('lab-order.report');

        Route::get("lab-orders", [LabOrderController::class, 'index'])->name("lab-orders.index");
    });
});
