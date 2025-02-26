<?php

namespace App\Http\Traits;

trait Common {
    public static function response($data, $msg, $code)
    {
        $response = [
            'status' => $code == 200 ? true : false,
            'code' => $code,
            'msg' => $msg,
            'version' => '1.0.0',
            'data' => $data
        ];
        return response()->json($response, $code);
    }

    public static function success($data = [], $msg = 'Success', $code = 200)
    {
        return self::response($data, $msg, $code);
    }

    /* Fail Respnose */

    public static function fail($data = [], $msg = "Some thing wen't wrong!", $code = 203)
    {
        return self::response($data, $msg, $code);
    }
}