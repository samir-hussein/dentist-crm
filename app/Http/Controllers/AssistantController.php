<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Interfaces\IAssistant;
use App\Http\Requests\Assistant\AssistantStoreRequest;
use App\Http\Requests\Assistant\AssistantUpdateRequest;
use App\Models\Assistant;

class AssistantController extends Controller
{
    private $service;

    public function __construct(IAssistant $assistantRepository)
    {
        $this->service = $assistantRepository;
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
        return $this->view("assistant.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("assistant.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssistantStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("assistants.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assistant $assistant)
    {
        $data = $this->service->findById($assistant);

        return $this->view("assistant.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssistantUpdateRequest $request, Assistant $assistant)
    {
        $data = $request->validated();

        $this->service->update($assistant, $data);

        return $this->redirectWithSuccess("assistants.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assistant $assistant)
    {
        $this->service->delete($assistant);
        return $this->redirectWithSuccess("assistants.index");
    }
}
