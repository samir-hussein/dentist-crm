<?php

namespace App\Http\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserUpdateProfileService extends UserService
{
    public function boot(User $user, array $data)
    {
        if ($data['new_password']) {
            if (!Hash::check($data['current_password'], auth()->user()->password)) {
                return $this->error("Invalid Current Password", 422);
            }
            $data['password'] = $data['new_password'];
            $data['unique_id'] = $data['password'];
        }

        $user->update($data);

        if (isset($data['avatar']) && $data['avatar'] != null) {
            $user->clearMediaCollection('avatar');
            $user->addMedia($data['avatar'])->toMediaCollection('avatar');
        }

        return $this->success();
    }
}
