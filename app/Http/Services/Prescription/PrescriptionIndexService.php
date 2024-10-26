<?php

namespace App\Http\Services\Prescription;

use App\Models\Diagnosis;
use App\Models\Dose;
use App\Models\Patient;
use stdClass;

class PrescriptionIndexService extends PrescriptionService
{
    public function boot()
    {
        $data = new stdClass;

        $data->medicines = $this->model->with('medicines')->get()->map(function ($row) {
            $row->medicine = $row->medicines->pluck('name'); // Use pluck to directly get an array of names
            unset($row->medicines);
            return $row;
        });

        $data->patients = Patient::all();

        $data->doses = Dose::pluck("dose");

        $data->diagnosis = Diagnosis::pluck("name");

        return $data;
    }
}
