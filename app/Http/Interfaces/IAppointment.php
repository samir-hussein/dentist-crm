<?php

namespace App\Http\Interfaces;

use App\Models\Appointment;
use Illuminate\Http\Request;

interface IAppointment
{
    public function all();
    public function store(array $requestData);
    public function update(Appointment $appointment, array $requestData);
    public function delete(Appointment $appointment);
    public function findById(Appointment $appointment);
    public function markCompleted(Appointment $appointment);
    public function necessaryData();
}
