<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IStaff;
use App\Http\Requests\Staff\StaffStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    private $service;

    public function __construct(IStaff $staffRepository)
    {
        $this->service = $staffRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->view("staff.index");
    }

    /**
     * Get a listing of the resource.
     */
    public function all(Request $request)
    {
        $data = $this->service->all($request);

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("staff.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("staff.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $staff)
    {
        $this->service->delete($staff);
        return $this->redirectWithSuccess("staff.index");
    }
}
