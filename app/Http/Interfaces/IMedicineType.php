<?php

namespace App\Http\Interfaces;

use App\Models\MedicineType;
use Illuminate\Http\Request;

interface IMedicineType
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(MedicineType $medicineType, array $requestData);
    public function delete(MedicineType $medicineType);
    public function findById(MedicineType $medicineType);
}
