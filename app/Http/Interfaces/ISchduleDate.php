<?php

namespace App\Http\Interfaces;

use App\Models\SchduleDate;
use Illuminate\Http\Request;

interface ISchduleDate
{
    public function all(Request $request);
    public function store();
    public function update(SchduleDate $schduleDate, array $requestData);
    public function delete(SchduleDate $schduleDate);
    public function findById(SchduleDate $schduleDate);
}
