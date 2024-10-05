<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Interfaces\IDoctor;
use App\Http\Services\Doctor\DoctorStoreService;
use App\Http\Services\Doctor\DoctorDeleteService;
use App\Http\Services\Doctor\DoctorGetAllService;

class DoctorRepository implements IDoctor
{
    private $doctorGetAllService;
    private $doctorStoreService;
    private $doctorDeleteService;

    public function __construct(
        DoctorGetAllService $doctorGetAllService,
        DoctorStoreService $doctorStoreService,
        DoctorDeleteService $doctorDeleteService
    ) {
        $this->doctorGetAllService = $doctorGetAllService;
        $this->doctorStoreService = $doctorStoreService;
        $this->doctorDeleteService = $doctorDeleteService;
    }

    public function all(Request $request)
    {
        return $this->doctorGetAllService->boot($request);
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
