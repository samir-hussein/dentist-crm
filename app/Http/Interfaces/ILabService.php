<?php

namespace App\Http\Interfaces;

use App\Models\LabService;
use Illuminate\Http\Request;

interface ILabService
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(LabService $labService, array $requestData);
    public function delete(LabService $labService);
    public function findById(LabService $labService);
}
