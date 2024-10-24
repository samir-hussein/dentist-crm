<?php

namespace App\Http\Services\Patient;

class PatientStoreService extends PatientService
{
    public function boot(array $data)
    {
        if (isset($data['medical_history']) && count($data['medical_history']) > 0) {
            $data['medical_history'] = implode(" - ", $data['medical_history']);
        }

        return $this->model->create($data);
    }
}
