<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use App\Http\Interfaces\IAssistant;
use App\Http\Services\Assistant\AssistantStoreService;
use App\Http\Services\Assistant\AssistantDeleteService;
use App\Http\Services\Assistant\AssistantGetAllService;
use App\Http\Services\Assistant\AssistantUpdateService;
use App\Http\Services\Assistant\AssistantFindByIdService;
use App\Models\Assistant;

class AssistantRepository implements IAssistant
{
    public function __construct(
        private AssistantGetAllService $assistantGetAllService,
        private AssistantStoreService $assistantStoreService,
        private AssistantDeleteService $assistantDeleteService,
        private AssistantFindByIdService $assistantFindById,
        private AssistantUpdateService $assistantUpdateService,
    ) {}

    public function all(Request $request)
    {
        return $this->assistantGetAllService->boot($request);
    }

    public function findById(Assistant $assistant)
    {
        return $this->assistantFindById->boot($assistant);
    }

    public function store(array $data)
    {
        return $this->assistantStoreService->boot($data);
    }

    public function update(Assistant $assistant, array $data)
    {
        return $this->assistantUpdateService->boot($assistant, $data);
    }

    public function delete(Assistant $assistant)
    {
        return $this->assistantDeleteService->boot($assistant);
    }
}
