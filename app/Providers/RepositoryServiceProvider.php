<?php

namespace App\Providers;

use App\Http\Interfaces\IAdmin;
use App\Http\Interfaces\IAppointment;
use App\Http\Interfaces\IAuth;
use App\Http\Interfaces\IDiagnosis;
use App\Http\Interfaces\IDoctor;
use App\Http\Interfaces\IDose;
use App\Http\Interfaces\IEloquent;
use App\Http\Interfaces\IInvoice;
use App\Http\Interfaces\ILab;
use App\Http\Interfaces\ILabOrder;
use App\Http\Interfaces\ILabService;
use App\Http\Interfaces\IMedicalHistory;
use App\Http\Interfaces\IMedicine;
use App\Http\Interfaces\IMedicineType;
use App\Http\Interfaces\IPatient;
use App\Http\Interfaces\IPrescription;
use App\Http\Interfaces\ISchduleDate;
use App\Http\Interfaces\ISchduleDay;
use App\Http\Interfaces\IService;
use App\Http\Interfaces\IStaff;
use App\Http\Interfaces\ITrearmentType;
use App\Http\Interfaces\ITreatmentSession;
use App\Http\Interfaces\IUser;
use App\Http\Repositories\AdminRepository;
use App\Http\Repositories\AppointmentRepository;
use App\Http\Repositories\AuthRepository;
use Illuminate\Support\ServiceProvider;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\DiagnosisRepository;
use App\Http\Repositories\DoctorRepository;
use App\Http\Repositories\DoseRepository;
use App\Http\Repositories\InvoiceRepository;
use App\Http\Repositories\LabOrderRepository;
use App\Http\Repositories\LabRepository;
use App\Http\Repositories\LabServiceRepository;
use App\Http\Repositories\MedicalHistoryRepository;
use App\Http\Repositories\MedicineRepository;
use App\Http\Repositories\MedicineTypeRepository;
use App\Http\Repositories\PatientRepository;
use App\Http\Repositories\PrescriptionRepository;
use App\Http\Repositories\SchduleDateRepository;
use App\Http\Repositories\SchduleDayRepository;
use App\Http\Repositories\ServiceRepository;
use App\Http\Repositories\StaffRepository;
use App\Http\Repositories\TreatmentSessionRepository;
use App\Http\Repositories\TreatmentTypeRepository;
use App\Http\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IEloquent::class, BaseRepository::class);
        $this->app->bind(IAuth::class, AuthRepository::class);
        $this->app->bind(IPatient::class, PatientRepository::class);
        $this->app->bind(IAdmin::class, AdminRepository::class);
        $this->app->bind(IStaff::class, StaffRepository::class);
        $this->app->bind(IDoctor::class, DoctorRepository::class);
        $this->app->bind(IService::class, ServiceRepository::class);
        $this->app->bind(IUser::class, UserRepository::class);
        $this->app->bind(ILab::class, LabRepository::class);
        $this->app->bind(IDiagnosis::class, DiagnosisRepository::class);
        $this->app->bind(IAppointment::class, AppointmentRepository::class);
        $this->app->bind(ITrearmentType::class, TreatmentTypeRepository::class);
        $this->app->bind(ILabService::class, LabServiceRepository::class);
        $this->app->bind(IDose::class, DoseRepository::class);
        $this->app->bind(IMedicineType::class, MedicineTypeRepository::class);
        $this->app->bind(IMedicine::class, MedicineRepository::class);
        $this->app->bind(ISchduleDay::class, SchduleDayRepository::class);
        $this->app->bind(ISchduleDate::class, SchduleDateRepository::class);
        $this->app->bind(IMedicalHistory::class, MedicalHistoryRepository::class);
        $this->app->bind(ITreatmentSession::class, TreatmentSessionRepository::class);
        $this->app->bind(IPrescription::class, PrescriptionRepository::class);
        $this->app->bind(IInvoice::class, InvoiceRepository::class);
        $this->app->bind(ILabOrder::class, LabOrderRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
