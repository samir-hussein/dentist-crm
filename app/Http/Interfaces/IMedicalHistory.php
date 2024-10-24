<?php

namespace App\Http\Interfaces;

use App\Models\MedicalHistory;
use Illuminate\Http\Request;

interface IMedicalHistory
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(MedicalHistory $medicalHistory, array $requestData);
    public function delete(MedicalHistory $medicalHistory);
    public function findById(MedicalHistory $medicalHistory);
}
