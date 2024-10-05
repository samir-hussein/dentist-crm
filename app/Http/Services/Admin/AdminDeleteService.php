<?php

namespace App\Http\Services\Admin;

use App\Models\User;

class AdminDeleteService extends AdminService
{
    public function boot(User $admin)
    {
        $admin->delete();

        return $this->success();
    }
}
