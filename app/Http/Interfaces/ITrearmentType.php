<?php

namespace App\Http\Interfaces;

use App\Models\TreatmentType;
use Illuminate\Http\Request;

interface ITrearmentType
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(TreatmentType $treatmentType, array $requestData);
    public function delete(TreatmentType $treatmentType);
    public function findById(TreatmentType $treatmentType);
    public function necessaryData();
}
