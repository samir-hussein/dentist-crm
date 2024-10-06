<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IAuth;
use App\Http\Interfaces\IUser;
use App\Http\Requests\User\UserUpdateProfileRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service;
    private $authService;

    public function __construct(IUser $userRepository, IAuth $authService)
    {
        $this->service = $userRepository;
        $this->authService = $authService;
    }

    /**
     * Display a listing of the resource.
     */
    public function profile(Request $request)
    {
        $data = $this->service->getProfile($request);

        return view('profile-settings', ["data" => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateProfileRequest $request)
    {
        $user = $request->user();

        $data = $request->validated();

        $response = $this->service->updateProfile($user, $data);

        if ($response['status'] == "error") {
            return $this->backWithError($response['errors']);
        }

        if ($data['new_password']) {
            $this->authService->logout();
            return $this->redirectWithSuccess("login");
        }

        return $this->backWithSuccess();
    }

    public function deleteProfileImage(Request $request)
    {
        $user = $request->user();

        return $this->service->deleteProfileImage($user);
    }
}
