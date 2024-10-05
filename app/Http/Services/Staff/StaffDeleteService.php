<?php

namespace App\Http\Services\Staff;

use App\Models\User;

class StaffDeleteService extends StaffService
{
    public function boot(User $staff)
    {
        $staff->delete();

        return $this->success();
    }
}
