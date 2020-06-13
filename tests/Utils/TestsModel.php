<?php

namespace Tests\Utils;

use Illuminate\Database\Eloquent\Model;

trait TestsModel
{
    /**
     * Model to test
     *
     * @return string
     */
    abstract protected function model(): string;

    /**
     * An instance of the testing model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function modelInstance(): Model
    {
        $model = $this->model();

        return new $model;
    }
}
