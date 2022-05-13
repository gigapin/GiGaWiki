<?php
namespace App\Traits;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

trait HasWebResposer
{
    public function errorResponse($message, $code)
    {
        return view('errors.response', [
            'message' => $message,
            'code' => $code
        ]);
    }
}
