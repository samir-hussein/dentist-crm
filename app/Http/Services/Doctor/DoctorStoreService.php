<?php

namespace App\Http\Services\Doctor;

class DoctorStoreService extends DoctorService
{
    public function boot(array $data)
    {
        $data['is_doctor'] = true;
        $data['unique_id'] = $data['password'];

        $doctor = $this->model->create($data);

        if (isset($data['avatar']) && $data['avatar'] != null) {
            $doctor->addMedia($data['avatar'])->toMediaCollection('avatar');
        }

        return $this->success();
    }
}
