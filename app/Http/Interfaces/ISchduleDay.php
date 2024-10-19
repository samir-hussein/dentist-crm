<?php

namespace App\Http\Interfaces;

use App\Models\SchduleDay;
use Illuminate\Http\Request;

interface ISchduleDay
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(SchduleDay $schduleDay, array $requestData);
    public function delete(SchduleDay $schduleDay);
    public function findById(SchduleDay $schduleDay);
}
