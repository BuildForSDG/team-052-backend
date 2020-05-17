<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\RespondsWithJson;
use App\Http\Controllers\Utils\SimplePaginates;
use App\Report;
use Laravel\Lumen\Http\Request;

class UserReportController extends Controller
{
    use RespondsWithJson, SimplePaginates;

    /**
     * Display a listing of all reports to user
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function list()
    {
        $reports = Report::orderBy('id', 'desc')->simplePaginate();

        return $this->listResponse($this->extractItemsFrom($reports), $this->extractMetaFrom($reports));
    }
}
