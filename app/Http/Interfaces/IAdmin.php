<?php

namespace App\Http\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface IAdmin
{
    public function all(Request $request);
    public function store(array $requestData);
    public function delete(User $admin);
}
