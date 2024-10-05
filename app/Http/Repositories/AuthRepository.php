<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\IAuth;
use App\Http\Services\Auth\LoginService;
use App\Http\Services\Auth\LogoutService;

class AuthRepository implements IAuth
{
    private $loginService;
    private $logoutService;

    public function __construct(LoginService $loginService, LogoutService $logoutService)
    {
        $this->loginService = $loginService;
        $this->logoutService = $logoutService;
    }

    public function login(array $requestData)
    {
        return $this->loginService->boot($requestData);
    }

    public function logout()
    {
        return $this->logoutService->boot();
    }
}
