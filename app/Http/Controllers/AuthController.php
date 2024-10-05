<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IAuth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $service;

    public function __construct(IAuth $authRepository)
    {
        $this->service = $authRepository;
    }

    public function index()
    {
        return $this->view("welcome");
    }

    public function login(LoginRequest $request)
    {
        $requestData = $request->validated();

        $response = $this->service->login($requestData);

        if ($response['status'] == "error") {
            return $this->backWithError($response['errors']);
        }

        return $this->intended();
    }

    public function logout()
    {
        $this->service->logout();

        return $this->redirectWithSuccess("login");
    }
}
