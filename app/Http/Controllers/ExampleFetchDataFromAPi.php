<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\JsonFilterHelper;
use App\Helpers\BarantinAPiHelper;
use Illuminate\Support\Facades\Http;

class ExampleFetchDataFromAPi extends Controller
{
    public function OnlyTestGetDataFromAPi()
    {
        try {

            $data = BarantinAPiHelper::getDataMasterUpt();

            $filter = JsonFilterHelper::filterByID($data->original, 1001);

            return response()->json($filter);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch data']);
        }

    }
}
