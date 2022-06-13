<?php

namespace App\Support;

use Illuminate\Http\Request;

class PaginateData
{
    /** @var integer */
    public $per_page = 20;

    /** @var integer */
    public $page = 1;

    /** @var string|null */
    public $sort = "";

    public static function fromRequest(Request $request)
    {
        $data = [
            'per_page' => intval($request->input('per_page') ?? 10),
            'page' => intval($request->input('page') ?? 1),
            'sort' => $request->input('sort') ?? "",
        ];

        return (object)$data;
    }
}
