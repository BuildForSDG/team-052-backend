<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\RespondsWithJson;
use App\Http\Controllers\Utils\SimplePaginates;
use App\Report;
use Laravel\Lumen\Http\Request;

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
        //
    }*/

    /**
     * Read a single report by its id
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    /*public function read($id)
    {
        //
    }*/

    /**
     * Update the status of a report
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    /*public function update(Request $request, $id)
    {
        //
    }*/

    /**
     * Delete a report from the database
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    /*public function delete($id)
    {
        //
    }*/

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

    public function status($id)
    {
        $reports = Report::find($id);
        //$reports->status  (to be edited later)
        $reports->save();
        return redirect()->back();
    }
}
