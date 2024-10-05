<?php

namespace App\Http\Traits;

trait HandlerResponse
{
    public function success(string $message = "Your request was processed successfully!", int $code = 200)
    {
        return [
            "status" => "success",
            "message" => $message,
            "code" => $code
        ];
    }

    public function error(string|array $errors = "Oops! There was an issue processing your request.", int $code)
    {
        return [
            "status" => "error",
            "errors" => $errors,
            "code" => $code
        ];
    }
}
