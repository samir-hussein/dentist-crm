<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Interfaces\IDoctor;
use App\Http\Services\Doctor\DoctorStoreService;
use App\Http\Services\Doctor\DoctorDeleteService;
use App\Http\Services\Doctor\DoctorGetAllService;
use App\Http\Services\Doctor\DoctorListService;
use App\Http\Services\Doctor\DoctorUpdateService;

class DoctorRepository implements IDoctor
{
    public function __construct(
        private DoctorGetAllService $doctorGetAllService,
        private DoctorStoreService $doctorStoreService,
        private DoctorDeleteService $doctorDeleteService,
        private DoctorListService $doctorListService,
        private DoctorUpdateService $doctorUpdateService
    ) {}

    public function all(Request $request)
    {
        return $this->doctorGetAllService->boot($request);
    }

    public function update(User $doctor, array $data)
    {
        return $this->doctorUpdateService->boot($doctor, $data);
    }

    public function listService()
    {
        return $this->doctorListService->boot();
    }

    public function store(array $data)
    {
        return $this->doctorStoreService->boot($data);
    }

    public function delete(User $doctor)
    {
        return $this->doctorDeleteService->boot($doctor);
    }
}
