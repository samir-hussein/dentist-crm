<?php

namespace App\Http\Interfaces;

use App\Models\Dose;
use Illuminate\Http\Request;

interface IDose
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(Dose $dose, array $requestData);
    public function delete(Dose $dose);
    public function findById(Dose $dose);
}
