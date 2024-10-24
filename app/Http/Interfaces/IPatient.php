<?php

namespace App\Http\Interfaces;

use App\Models\Patient;
use Illuminate\Http\Request;

interface IPatient
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(Patient $patient, array $requestData);
    public function delete(Patient $patient);
    public function findById(Patient $patient);
    public function necessaryData();
}
