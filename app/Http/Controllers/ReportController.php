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
    public function store(Request $request)
    {
        // perform storage logic here


        // after storing the report to the database,
        // return a store response with an instance of the reported model

        //return $this->storeResponse($report);
    }

    /**
     * Read a single report by its id
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function read(int $id)
    {
        // @issue 6
        // As an admin, I want to be able to know the time of report,
        // location, visual feedback and reporter of an incident.

        // write logic here to extract
        // the report from the database by its id

        // return a read response with an instance of the report model
        // return $this->readResponse($report)
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
    public function delete($id)
    {
        // write logic to delete a report from the database

        return $this->deleteResponse();
    }

    /**
     * Display a listing of all reports
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function list()
    {
        $reports = Report::orderBy('id', 'desc')->simplePaginate();

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
