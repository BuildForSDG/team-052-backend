<?php

namespace App\Http\Controllers\Utils;

use Illuminate\Pagination\Paginator;

trait SimplePaginates
{
    /**
     * Extracts metadata from a paginated instance
     *
     * @param \Illuminate\Pagination\Paginator $data
     */
    protected function extractMetaFrom(Paginator $data)
    {
        $meta = [
            'current_page' => $data->currentPage(),
            'first_page_url' => $data->url(1),
            'from' => $data->firstItem(),
            'next_page_url' => $data->nextPageUrl(),
            'path' => $data->path(),
            'per_page' => $data->perPage(),
            'prev_page_url' => $data->previousPageUrl(),
            'to' => $data->lastItem(),
        ];

        return $meta;
    }

    /**
     * Extracts the items from a paginated instance
     *
     * @param \Illuminate\Pagination\Paginator $data
     */
    protected function extractItemsFrom(Paginator $data)
    {
        return $data->items();
    }
}
