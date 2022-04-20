<?php
namespace App\Traits;

trait HasWebResposer
{
    protected function errorResponse($message, $code)
    {
        return view('errors.response', [
            'message' => $message,
            'code' => $code
        ]);
    }
}
