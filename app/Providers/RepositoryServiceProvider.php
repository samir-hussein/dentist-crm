<?php

namespace App\Providers;

use App\Http\Interfaces\IAuth;
use App\Http\Interfaces\IEloquent;
use App\Http\Interfaces\IPatient;
use App\Http\Repositories\AuthRepository;
use Illuminate\Support\ServiceProvider;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\PatientRepository;

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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
