<?php

namespace App\Http\Interfaces;

use App\Models\Lab;
use Illuminate\Http\Request;

interface ILab
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(Lab $lab, array $requestData);
    public function delete(Lab $lab);
    public function findById(Lab $lab);
}
