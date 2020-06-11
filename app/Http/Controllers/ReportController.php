<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\RespondsWithJson;
use App\Http\Controllers\Utils\SimplePaginates;
use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use RespondsWithJson, SimplePaginates;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Store a report in the database
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    /*public function store(Request $request)
    {
        // perform storage logic here


        // after storing the report to the database,
        // return a store response with an instance of the reported model

        //return $this->storeResponse($report);
    }*/

    /**
     * Read a single report by its id
     *
     * @param int $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function read(int $id)
    {
        $report = Report::findOrFail($id);

        return $this->readResponse($report);
    }

    /**
     * Update the status of a report
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function update(Request $request, $id)
    {
        //@issue 7
        // As an admin, I want to be able to mark an incident as pending, enroute, onsite, or acknowledged

        // write logic here to update the status of a report
        // get the new status with $request->input('status')
        // ensure to validate the status against allowed statuses. i.e pending, acknowledged, enroute, e.t.c
        // tip: use Rule::in($allowed_statuses) to validate against required statuses


        // return an updateResponse afterwards
        return $this->updateResponse();
    }

    /**
     * Delete a report from the database
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    /*public function delete($id)
    {
        // write logic to delete a report from the database

        return $this->deleteResponse();
    }*/

    /**
     * Display a listing of all reports
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function list(Request $request)
    {
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
    }

    /**
     * Get the metrics data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function metrics()
    {
        //@issue 10
        // As an admin, I want to be able to view our progress metric,
        //so I can better report my response success
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
