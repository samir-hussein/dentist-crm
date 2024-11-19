<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface IShift
{
    public function all(Request $request, int $assistant_id);
    public function store(array $requestData, int $assistant_id);
}
