<?php

namespace App\Providers;

use App\Http\Interfaces\IAdmin;
use App\Http\Interfaces\IAuth;
use App\Http\Interfaces\IEloquent;
use App\Http\Interfaces\IPatient;
use App\Http\Interfaces\IStaff;
use App\Http\Repositories\AdminRepository;
use App\Http\Repositories\AuthRepository;
use Illuminate\Support\ServiceProvider;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\PatientRepository;
use App\Http\Repositories\StaffRepository;

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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
