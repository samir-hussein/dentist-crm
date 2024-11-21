<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface IShift
{
    public function all(Request $request);
    public function store(array $requestData);
}
