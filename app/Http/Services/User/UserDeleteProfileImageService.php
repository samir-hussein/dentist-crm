<?php

namespace App\Http\Services\User;

use App\Models\User;

class UserDeleteProfileImageService extends UserService
{
    public function boot(User $user)
    {
        $user->clearMediaCollection('avatar');

        return $this->success();
    }
}
