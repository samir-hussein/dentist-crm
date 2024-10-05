<?php

namespace App\Providers;

use App\Http\Interfaces\IAdmin;
use App\Http\Interfaces\IAuth;
use App\Http\Interfaces\IDoctor;
use App\Http\Interfaces\IEloquent;
use App\Http\Interfaces\IPatient;
use App\Http\Interfaces\IService;
use App\Http\Interfaces\IStaff;
use App\Http\Interfaces\IUser;
use App\Http\Repositories\AdminRepository;
use App\Http\Repositories\AuthRepository;
use Illuminate\Support\ServiceProvider;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\DoctorRepository;
use App\Http\Repositories\PatientRepository;
use App\Http\Repositories\ServiceRepository;
use App\Http\Repositories\StaffRepository;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
