<?php

namespace App\Http\Services\User;

use Illuminate\Http\Request;

class UserGetProfileService extends UserService
{
    public function boot(Request $request)
    {
        $user = $request->user();

        $default_avatar = env("APP_URL") . "/images/avatar.jpg";

        $user->avatar_url = $user->getFirstMediaUrl('avatar') ?: $default_avatar;

        unset($user->media);

        return $user;
    }
}
