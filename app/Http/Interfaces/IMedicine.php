<?php

namespace App\Http\Interfaces;

use App\Models\Medicine;
use Illuminate\Http\Request;

interface IMedicine
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(Medicine $medicine, array $requestData);
    public function delete(Medicine $medicine);
    public function findById(Medicine $medicine);
}
