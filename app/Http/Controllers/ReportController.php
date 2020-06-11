<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\RespondsWithJson;
use App\Http\Controllers\Utils\SimplePaginates;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $report = Report::findOrFail($id);

        $data = $this->validate($request, [
            'status' => ['required', Rule::in(['pending', 'acknowledged', 'enroute'])]
        ]);
        $status = $data['status'];

        $report->status = $status;
        $report->save();

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
        $reported_cases = Report::count();
        $pending_cases = Report::where('status', 'pending')->count();
        $enroute_cases = Report::where('status', 'enroute')->count();
        $onsite_cases = Report::where('status', 'onsite')->count();
        $acknowledged_cases = Report::where('status', 'acknowledged')->count();

        return response()->json(compact('reported_cases', 'pending_cases', 'enroute_cases', 'onsite_cases', 'acknowledged_cases'), 200);
    }
}
