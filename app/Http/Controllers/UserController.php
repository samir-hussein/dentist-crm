<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service;

    public function __construct(IUser $userRepository)
    {
        $this->service = $userRepository;
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
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validated();

        $this->service->updateProfile($user, $data);

        return $this->backWithSuccess();
    }
}
