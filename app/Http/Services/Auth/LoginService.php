<?php

namespace App\Http\Services\Auth;

use Illuminate\Support\Facades\Auth;

class LoginService extends AuthService
{
    public function boot(array $requestData)
    {
        $credentials = [
            "email" => $requestData["email"],
            "password" => $requestData["password"]
        ];

        $remember = $requestData["remember"];

        if (Auth::attempt($credentials, $remember)) {
            // Authentication passed
            return $this->success();
        }

        return $this->error("Invalid email or password.", 422);
    }
}
