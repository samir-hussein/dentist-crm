<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IBranch;
use App\Http\Requests\Branch\BranchStoreRequest;
use App\Http\Requests\Branch\BranchUpdateRequest;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    private $service;

    public function __construct(IBranch $branchRepository)
    {
        $this->service = $branchRepository;
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
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->view("branch.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("branch.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("branches.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        $data = $this->service->findById($branch);

        return $this->view("branch.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BranchUpdateRequest $request, Branch $branch)
    {
        $data = $request->validated();

        $this->service->update($branch, $data);

        return $this->redirectWithSuccess("branches.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $this->service->delete($branch);
        return $this->redirectWithSuccess("branches.index");
    }
}
