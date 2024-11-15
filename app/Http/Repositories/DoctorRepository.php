<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Interfaces\IDoctor;
use App\Http\Services\Doctor\DoctorStoreService;
use App\Http\Services\Doctor\DoctorDeleteService;
use App\Http\Services\Doctor\DoctorGetAllService;
use App\Http\Services\Doctor\DoctorListService;

class DoctorRepository implements IDoctor
{
    private $doctorGetAllService;
    private $doctorStoreService;
    private $doctorDeleteService;
    private $doctorListService;

    public function __construct(
        DoctorGetAllService $doctorGetAllService,
        DoctorStoreService $doctorStoreService,
        DoctorDeleteService $doctorDeleteService,
        DoctorListService $doctorListService
    ) {
        $this->doctorGetAllService = $doctorGetAllService;
        $this->doctorStoreService = $doctorStoreService;
        $this->doctorDeleteService = $doctorDeleteService;
        $this->doctorListService = $doctorListService;
    }

    public function all(Request $request)
    {
        return $this->doctorGetAllService->boot($request);
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
