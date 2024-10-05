<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IAdmin;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $service;

    public function __construct(IAdmin $adminRepository)
    {
        $this->service = $adminRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->view("admin.index");
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
        return $this->view("admin.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("admins.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        $this->service->delete($admin);
        return $this->redirectWithSuccess("admins.index");
    }
}
