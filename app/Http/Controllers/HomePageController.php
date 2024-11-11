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
        $data = $this->service->all(true);

        return $this->view("home", ['data' => $data['data']]);
    }
}
