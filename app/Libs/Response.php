<?php

namespace App\Libs;

use Illuminate\Http\JsonResponse;

class Response
{
    public static function response($status, $message, $data, $code)
    {
        return response()->json([
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
