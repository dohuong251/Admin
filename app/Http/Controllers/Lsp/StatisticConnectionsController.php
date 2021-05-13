<?php

namespace App\Http\Controllers\Lsp;

use App\Http\Controllers\Controller;
use App\Models\Tool\Connection;
use Carbon\Carbon;
use Config;
use Illuminate\Http\Request;

class StatisticConnectionsController extends Controller
{
    //
    public function index()
    {
        return view("lsp.analytic_connection");
    }

    public function filter(Request $request)
    {
        $startTime = Carbon::createFromTimestampMs($request->get("date-range-start", microtime(true) * 1000));
        $endTime = Carbon::createFromTimestampMs($request->get("date-range-end", microtime(true) * 1000));
    }

    public function searchVersion(Request $request)
    {
        $query = $request->get("search");
        $results = Connection::where("id_application", $request->get("id_application"))
            ->where("Version", "like", "%$query%")
            ->select("Version")
            ->distinct("Version")
            ->get();

        return array(
            "results" => array_values($results->map(function ($version) {
                return [
                    "id" => $version->Version,
                    "text" => $version->Version
                ];
            })->sortBy('text')->toArray()),
            "pagination" => array(
                "more" => false,
            )
        );
    }

    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
    }

    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
    }
}
