<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Interfaces\IUser;
use App\Http\Services\User\UserGetProfileService;
use App\Http\Services\User\UserUpdateProfileService;
use App\Http\Services\User\UserDeleteProfileImageService;

class UserRepository implements IUser
{
    private $userGetProfileService;
    private $userUpdateProfileService;
    private $userDeleteProfileImageService;

    public function __construct(
        UserGetProfileService $userGetProfileService,
        UserUpdateProfileService $userUpdateProfileService,
        UserDeleteProfileImageService $userDeleteProfileImageService
    ) {
        $this->userGetProfileService = $userGetProfileService;
        $this->userUpdateProfileService = $userUpdateProfileService;
        $this->userDeleteProfileImageService = $userDeleteProfileImageService;
    }

    public function getProfile(Request $request)
    {
        return $this->userGetProfileService->boot($request);
    }

    public function updateProfile(User $user, array $data)
    {
        return $this->userUpdateProfileService->boot($user, $data);
    }

    public function deleteProfileImage(User $user)
    {
        return $this->userDeleteProfileImageService->boot($user);
    }
}
