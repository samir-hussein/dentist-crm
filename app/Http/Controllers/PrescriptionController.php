<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IPrescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    private $service;

    public function __construct(IPrescription $prescriptionRepository)
    {
        $this->service = $prescriptionRepository;
    }

    public function index()
    {
        $data = $this->service->index();

        return $this->view("prescription", ['data' => $data]);
    }
}
