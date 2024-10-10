<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface IDiagnosis
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(int $diagnosis, array $requestData);
    public function delete(int $diagnosis);
    public function findById(int $diagnosis);
}
