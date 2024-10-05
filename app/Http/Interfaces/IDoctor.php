<?php

namespace App\Http\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface IDoctor
{
    public function all(Request $request);
    public function store(array $requestData);
    public function delete(User $doctor);
}
