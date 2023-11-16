<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Http\Resources\ReportResource;
use App\Helpers\ApiResponse;

class ReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
            $inputs = $request->input();
           $report = ReportService::report($inputs['starting_date'],$inputs['ending_date']);
           return ReportResource::collection($report);
        }
       
}
