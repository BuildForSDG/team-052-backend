<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\RespondsWithJson;
use App\Http\Controllers\Utils\SimplePaginates;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function store(Request $request)
    {
        $messages = require(resource_path('lang/en/validation.php'));

        $data = $this->validate($request, $this->creationRules(), $messages);

        /**
         * @var \Illuminate\Http\UploadedFile $uploaded_file
         */
        $uploaded_file = $data['visual_image'];
        $path = $uploaded_file->store('');

        $report = new Report();
        $report->title = $data['title'];
        $report->location = $data['location'];
        $report->visual_image = Storage::url($path);
        $report->save();

        return $this->storeResponse($report);
    }

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

        $messages = require(resource_path('lang/en/validation.php'));
        $data = $this->validate($request, [
            'status' => ['required', Rule::in(['pending', 'acknowledged', 'enroute'])]
        ], $messages);
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
        if (!empty($request->status)) {
            $reports = Report::where('status', $request->status)->orderBy('id', 'desc')->simplePaginate();
        } elseif (!empty($request->time)) {
            $reports = Report::where('time_of_report', $request->time)->orderBy('id', 'desc')->simplePaginate();
        } elseif (!empty($request->location)) {
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

    /**
     * An array of validation rules for creating a report
     *
     * @return array
     */
    protected function creationRules()
    {
        return [
            'title' => ['nullable'],
            'location' => ['required'],
            'visual_image' => ['required', 'image']
        ];
    }
}
