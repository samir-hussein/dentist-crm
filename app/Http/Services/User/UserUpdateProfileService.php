<?php

namespace App\Http\Services\User;

use App\Models\User;

class UserUpdateProfileService extends UserService
{
    public function boot(User $user, array $data)
    {
        $user->update($data);

        if (isset($data['avatar']) && $data['avatar'] != null) {
            $user->clearMediaCollection('avatar');
            $user->addMedia($data['avatar'])->toMediaCollection('avatar');
        }

        return $this->success();
    }
}
