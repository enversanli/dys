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
}
