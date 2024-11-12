<?php

namespace App\Http\Interfaces;

use App\Models\LabOrder;
use Illuminate\Http\Request;

interface ILabOrder
{
    public function index();
    public function report();
    public function update(LabOrder $labOrder, array $data);
}
