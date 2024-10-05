<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Interfaces\IAdmin;
use App\Http\Services\Admin\AdminStoreService;
use App\Http\Services\Admin\AdminDeleteService;
use App\Http\Services\Admin\AdminGetAllService;

class AdminRepository implements IAdmin
{
    private $adminGetAllService;
    private $adminStoreService;
    private $adminDeleteService;

    public function __construct(
        AdminGetAllService $adminGetAllService,
        AdminStoreService $adminStoreService,
        AdminDeleteService $adminDeleteService
    ) {
        $this->adminGetAllService = $adminGetAllService;
        $this->adminStoreService = $adminStoreService;
        $this->adminDeleteService = $adminDeleteService;
    }

    public function all(Request $request)
    {
        return $this->adminGetAllService->boot($request);
    }

    public function store(array $data)
    {
        return $this->adminStoreService->boot($data);
    }

    public function delete(User $admin)
    {
        return $this->adminDeleteService->boot($admin);
    }
}
