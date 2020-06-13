<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * Column name for created at timestamp
     *
     * @return string
     */
    const CREATED_AT = 'time_of_report';

    /**
     * Column name for updated_at timestamp
     *
     * @return string
     */
    const UPDATED_AT = 'status_updated_at';

    /**
     * The attributes that aren't mass assignable
     *
     * @return array
     */
    protected $guarded = [
        'status',
    ];

    /**
     * The default values for attributes
     *
     * @var array
     */
    protected $attributes = [
        'status'    =>  'pending'
    ];
}
