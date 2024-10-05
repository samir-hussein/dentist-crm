<?php

namespace App\Http\Interfaces;

interface IAuth
{
    public function login(array $requestData);
    public function logout();
}
