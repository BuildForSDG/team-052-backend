<?php

namespace App\Http\Controllers\Utils;

use Illuminate\Database\Eloquent\Model;

trait RespondsWithJson
{
    /**
     * Send a json response when a resource is stored successfully
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function storeResponse(Model $model)
    {
        return response()->json([
            'message' =>  'created',
            'data' =>  $model
        ], 201);
    }

    /**
     * Send a json response when a single resource is read successfully
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function readResponse($model)
    {
        return response()->json([
            'data' =>  $model
        ], 200);
    }

    /**
     * Send a json response when a resource is updated successfully
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function updateResponse()
    {
        return response()->json([], 204);
    }

    /**
     * Send a json response when a resource is deleted successfully
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function deleteResponse()
    {
        return response()->json([], 200);
    }

    /**
     * Send a json response when a resource list is viewed
     *
     * @param array $data
     * @param mixed $meta
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function listResponse($data, $meta)
    {
        return response()->json([
            'meta'  =>  $meta,
            'data'  =>  $data
        ], 200);
    }
}
