<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\RespondsWithJson;
//use App\Http\Controllers\Utils\SimplePaginates;
use App\Report;
//use App\ all other model necessary to be displayed on the dashboard
use Laravel\Lumen\Http\Request;

class DashboardController extends Controller
{
    use RespondsWithJson;


    /**
     * Display of all Incidents
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function index()
    {
        // awaiting other model to complete dashboard function
    }
}
