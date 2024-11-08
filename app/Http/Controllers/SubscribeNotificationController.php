<?php

namespace App\Http\Controllers;

use App\Models\SubscribeNotification;
use Illuminate\Http\Request;

class SubscribeNotificationController extends Controller
{
    public function subscribe(Request $request)
    {
        SubscribeNotification::updateOrCreate([
            'token' => $request->token,
            'user_id' => $request->user()->id,
        ], [
            'token' => $request->token,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Subscribed successfully!',
        ], 200);
    }
}
