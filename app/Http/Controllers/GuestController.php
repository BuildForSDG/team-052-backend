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

        // write your logic here to calculate the progress metric
        // this method should also perform the same operation
        // as in the reports controller metrics

        // tip: you can create a trait or class that calculates this metric
        // and use it for this controller and the reports controller

        return reponse()->json([
            //'data' => $metrics e.g { 'response_rate': 60%, 'reported_cases': 200 } e.t.c
        ], 200);
    }
}
