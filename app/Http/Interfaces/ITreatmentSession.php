<?php

namespace App\Http\Interfaces;

use App\Models\Patient;
use App\Models\TreatmentDetail;
use Illuminate\Http\Request;

interface ITreatmentSession
{
    public function start(Patient $patient);
    public function tabs(array $data);
    public function toothPanorama(Patient $patient, string $toothNumber);
    public function panoramaUploadFiles(Patient $patient, array $data);
    public function panoramaDelete(Patient $patient, int $id);
    public function toothUploadFiles(Patient $patient, array $data, string $toothNumber);
    public function toothDelete(Patient $patient, int $id, string $toothNumber);
    public function storeTreatmentSession(Patient $patient, array $data);
    public function updateTreatmentSession(TreatmentDetail $treatmentDetail, Patient $patient, array $data);
    public function showById(TreatmentDetail $treatmentDetail, Patient $patient);
    public function getAll(Request $request);
}
