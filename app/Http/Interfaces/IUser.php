<?php

namespace App\Http\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface IUser
{
    public function getProfile(Request $request);
    public function updateProfile(User $user, array $data);
}
