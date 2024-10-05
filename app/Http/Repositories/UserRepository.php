<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Interfaces\IUser;
use App\Http\Services\User\UserGetProfileService;
use App\Http\Services\User\UserUpdateProfileService;

class UserRepository implements IUser
{
    private $userGetProfileService;
    private $userUpdateProfileService;

    public function __construct(
        UserGetProfileService $userGetProfileService,
        UserUpdateProfileService $userUpdateProfileService
    ) {
        $this->userGetProfileService = $userGetProfileService;
        $this->userUpdateProfileService = $userUpdateProfileService;
    }

    public function getProfile(Request $request)
    {
        return $this->userGetProfileService->boot($request);
    }

    public function updateProfile(User $user, array $data)
    {
        return $this->userUpdateProfileService->boot($user, $data);
    }
}
