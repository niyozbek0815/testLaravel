<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function successResponse(string $message, $data = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data
        ]);
    }
}