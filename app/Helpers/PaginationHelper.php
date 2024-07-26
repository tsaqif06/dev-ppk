<?php

namespace App\Helpers;

class PaginationHelper
{
    public static function pagination($paginate, $data)
    {
        return [
            'data' => $data,
            'first_page_url' => $paginate->url(1),
            'from' => 1,
            'last_page' => $paginate->lastPage(),
            'last_page_url' => $paginate->url($paginate->lastPage()),
            'links' => $paginate->linkCollection()->toArray(),
            'next_page_url' => $paginate->nextPageUrl(),
            'path' => $paginate->path(),
            'per_page' => $paginate->perPage(),
            'prev_page_url' => $paginate->previousPageUrl(),
            'to' => $paginate->count(),
            'total' => $paginate->total()
        ];
    }
}
