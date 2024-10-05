<?php

namespace App\Http\Traits;

trait ControllerResponse
{
    public function view(string $name, array $data = [])
    {
        return view($name, $data);
    }

    public function backWithSuccess($message = "Your request was processed successfully!")
    {
        return redirect()->back()->with("success", $message);
    }

    public function backWithError($message = "Oops! There was an issue processing your request.")
    {
        return redirect()->back()->with("error", $message);
    }

    public function redirectWithSuccess($route, $message = "Your request was processed successfully!")
    {
        return redirect()->route($route)->with("success", $message);
    }

    public function redirectWithError($route, $message = "Oops! There was an issue processing your request.")
    {
        return redirect()->route($route)->with("error", $message);
    }

    public function intended($route = 'home')
    {
        return redirect()->intended($route);
    }
}
