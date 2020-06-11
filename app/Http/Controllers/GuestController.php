<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\RespondsWithJson;
use App\Http\Controllers\Utils\SimplePaginates;
use Symfony\Component\HttpFoundation\Request;

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
        //@issue 2
        // As a user, I want to be able to view recently reported incidents

        // this method should get the recently reported incidents
        // just like (new ReportController)->list() will do but the data returned
        // should be limited to title, location, visual_image and time_report
        // tip: use select() eloquent query method to select only the required columns
        if(!empty($request->status)){
            $reports = Report::where('status', $request->status)->orderBy('id', 'desc')->simplePaginate();
        }elseif(!empty($request->time)){
            $reports = Report::where('time_of_report', $request->time)->orderBy('id', 'desc')->simplePaginate();
        }elseif(!empty($request->location)){
            $reports = Report::where('location', $request->location)->orderBy('id', 'desc')->simplePaginate();
        } else {
            $reports = Report::orderBy('id', 'desc')->simplePaginate();
        }
        return $this->listResponse($this->extractItemsFrom($reports), $this->extractMetaFrom($reports));


        // return a list response just like in the report controller
        //return $this->listResponse($this->extractItemsFrom($reports), $this->extractMetaFrom($reports));

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
