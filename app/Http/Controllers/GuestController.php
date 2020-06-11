<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\RespondsWithJson;
use App\Http\Controllers\Utils\SimplePaginates;
use App\Report;

class GuestController extends Controller
{
    use RespondsWithJson, SimplePaginates;

    /**
     * Get recently reported incidents
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reports()
    {
        //@issue 2
        // As a user, I want to be able to view recently reported incidents
        $reports = Report::where('title', 'location', 'visual_image', 'time_of_report')->orderBy('time_of_report', 'desc')->simplePaginate();

        return $this->listResponse($this->extractItemsFrom($reports), $this->extractMetaFrom($reports));
    }

    /**
     * Get the metrics data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function metrics()
    {
        //@issue 4
        // As a user, I want to be able to view the progress metric,
        // so that I can evaluate the response rate of the team
        $reported_cases = Report::count();
        $pending_cases = Report::where('status', 'pending')->count();
        $enroute_cases = Report::where('status', 'enroute')->count();
        $onsite_cases = Report::where('status', 'onsite')->count();
        $acknowledged_cases = Report::where('status', 'acknowledged')->count();

        return response()->json([
            'metrics' => view ('metrics')
            ->with('reported_cases', $reported_cases)
            ->with('pending_cases', $pending_cases)
            ->with('enroute_cases', $enroute_cases)
            ->with('onsite_cases', $onsite_cases)
            ->with('acknowledged_cases', $acknowledged_cases)
        ], 200);
    }
}