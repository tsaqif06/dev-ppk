<?php

namespace App\Helpers;

class JsonFilterHelper
{
    public static function filterByID(mixed $data, mixed $filter)
    {
        return collect($data)->filter(function ($item) use ($filter) {
            return is_array($filter) ? in_array($item['id'], $filter) : $item['id'] === $filter;
        })->values();
    }
    public static function searchDataByKeyword($data, $keyword, string ...$items)
    {
        return $data->filter(function ($item) use ($keyword, $items) {
            foreach ($items as $value) {
                if (str_contains(strtolower($item[$value]), strtolower($keyword))) {
                    return true;
                }
            }
            return false;
        })->values();

    }

}
