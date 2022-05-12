<?php

namespace App\Support;

class ResponseMessage
{
    public static function returnData($status = true, $data = null, $message = null)
    {
        if (empty($message) && $status)
            $message = __('common.success');

        if (empty($message) && !$status)
            $message = __('common.went_wrong');

        return (object)[
            'status' => $status,
            'data' => $data,
            'message' => $message
        ];
    }

    public static function success($message = null, $data  = null, $code = 200)
    {
        if ($message == null) {
            $message = __('common.success');
        }

        return (object)[
            'status' => true,
            'data' => $data,
            'message' => $message,
            'code' => $code
        ];
    }

    public static function failed($message = null, $error = null, $code = 400)
    {
        if ($message == null) {
            $message = __('common.went_wrong');
        }

        return (object)[
            'status' => false,
            'message' => $message,
            'error' => $error,
            'code' => $code
        ];
    }
}
