<?php

namespace App\Http\Services\Doctor;

use App\Models\User;

class DoctorDeleteService extends DoctorService
{
    public function boot(User $doctor)
    {
        $doctor->delete();

        return $this->success();
    }
}
