<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Interfaces\IAppointment;

class HomePageController extends Controller
{
    private $service;

    public function __construct(IAppointment $appointmentRepository)
    {
        $this->service = $appointmentRepository;
    }

    public function index()
    {
        return $this->view("home");
    }
}
