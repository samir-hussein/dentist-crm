<?php

namespace App\Http\Services\Doctor;

class DoctorListService extends DoctorService
{
    public function boot()
    {
        // Fetch all columns from your model's table
        $data = $this->model->where("is_doctor", true)->get(['id', 'name']);

        return $data;
    }
}
