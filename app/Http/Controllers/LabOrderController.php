<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ILab;
use App\Models\LabOrder;
use Illuminate\Http\Request;
use App\Http\Interfaces\ILabOrder;
use App\Http\Requests\LabOrder\LabOrderUpdateRequest;

class LabOrderController extends Controller
{
    private $service;

    public function __construct(ILabOrder $labOrderRepository, private ILab $labService)
    {
        $this->service = $labOrderRepository;
    }

    /**
     * Get a listing of the resource.
     */
    public function all()
    {
        $data = $this->service->index();

        return $data;
    }

    /**
     * Get a listing of the resource.
     */
    public function index()
    {
        return view("lab-orders");
    }

    public function reportView()
    {
        $data = $this->labService->labList();
        return view("lab-orders-report", ['labs' => $data]);
    }

    public function report()
    {
        $data = $this->service->report();

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update(LabOrderUpdateRequest $request, LabOrder $labOrder)
    {
        $data = $request->validated();

        $this->service->update($labOrder, $data);

        return response()->json(["status" => "success"]);
    }
}
