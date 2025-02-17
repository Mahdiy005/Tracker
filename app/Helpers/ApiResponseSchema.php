<?php

namespace App\Helpers;

class ApiResponseSchema
{
    public static function sendResponse($code = 200, $msg = '', $data = [])
    {
        $data = [
            'status' => $code,
            'message' => $msg,
            'data' => $data
        ];
        return response()->json($data, $code);
    }
}