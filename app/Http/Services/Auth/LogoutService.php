<?php

namespace App\Http\Services\Auth;

use Illuminate\Support\Facades\Auth;

class LogoutService extends AuthService
{
    public function boot()
    {
        Auth::logout();

        return $this->success();
    }
}
