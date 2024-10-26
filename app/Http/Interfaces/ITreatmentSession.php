<?php

namespace App\Http\Interfaces;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

interface ITreatmentSession
{
    public function start(Appointment $appointment);
    public function tabs(array $data);
    public function toothPanorama(Patient $patient, string $toothNumber);
}
