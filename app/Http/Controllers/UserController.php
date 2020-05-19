<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\RespondsWithJson;
use App\Http\Controllers\Utils\SimplePaginates;
use Illuminate\Http\Client\Request;

class UserController extends Controller
{
    use RespondsWithJson, SimplePaginates;

    /**
     * Store a new admin user to the database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request)
    {
        // @issue 8
        // write your store logics here
        //

        // afterwards, return a store response with
        // an instance of model  of the user created
        // return $this->storeResponse($admin);
    }
}
