<?php

namespace App\Http\Interfaces;

use App\Models\Service;
use Illuminate\Http\Request;

interface IService
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(Service $service, array $requestData);
    public function delete(Service $service);
    public function findById(Service $service);
}
