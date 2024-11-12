<?php

namespace App\Http\Interfaces;

use App\Models\Branch;
use Illuminate\Http\Request;

interface IBranch
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(Branch $branch, array $requestData);
    public function delete(Branch $branch);
    public function findById(Branch $branch);
}
