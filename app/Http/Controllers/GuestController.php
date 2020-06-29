<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\RespondsWithJson;
use App\Http\Controllers\Utils\SimplePaginates;
use App\Report;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    use RespondsWithJson, SimplePaginates;

    /**
     * Get recently reported incidents
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reports(Request $request)
    {
        if (!empty($request->status)) {
            $reports = Report::where('status', $request->status)->orderBy('id', 'desc');
        } elseif (!empty($request->time)) {
            $reports = Report::where('time_of_report', $request->time)->orderBy('id', 'desc');
        } elseif (!empty($request->location)) {
            $reports = Report::where('location', $request->location)->orderBy('id', 'desc');
        } else {
            $reports = Report::orderBy('id', 'desc');
        }

        $reports = $reports->select('title', 'location', 'visual_image', 'status', 'time_of_report')->simplePaginate();

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

        return response()->json(compact('reported_cases', 'pending_cases', 'enroute_cases', 'onsite_cases', 'acknowledged_cases'), 200);
    }
}
