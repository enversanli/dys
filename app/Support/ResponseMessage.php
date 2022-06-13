<?php

namespace App\Support;

use Illuminate\Http\Response;

class ResponseMessage
{
    public static function returnData($status = true, $data = null, $message = null, $code = 400)
    {
        if (empty($message) && $status)
            $message = __('common.success');

        if (empty($message) && !$status)
            $message = __('common.went_wrong');

        return (object)[
            'status' => $status,
            'data' => $data,
            'message' => $message,
            'code' => $code
        ];
    }

    public static function paginate($message = null, $data = [])
    {
        if (is_null($message)) {
            $message = __('Successful');
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data->resource->items(),
            'pagination' => [
                'total' => $data->resource->total(),
                'count' => $data->resource->count(),
                'per_page' => $data->resource->perPage(),
                'current_page' => $data->resource->currentPage(),
                'total_pages' => $data->resource->lastPage()
            ],
        ], Response::HTTP_OK);

    }

    public static function success($message = null, $data  = null, $code = 200)
    {
        if ($message == null) {
            $message = __('common.success');
        }

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
            'code' => $code
        ], $code);
    }

    public static function failed($message = null, $error = null, $code = 400)
    {
        if ($message == null) {
            $message = __('common.went_wrong');
        }

        return response()->json([
            'status' => false,
            'message' => $message,
            'error' => $error,
            'code' => $code
        ], $code);
    }

    public static function unauthorized($message = null)
    {
        if (is_null($message)) {
            $message = __('Error');
        }

        return response()->json([
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' => $message
        ], Response::HTTP_UNAUTHORIZED);
    }

}
