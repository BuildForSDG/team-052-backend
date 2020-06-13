<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('OPTIONS')) {
            return response()->json([
                'method' => 'OPTIONS'
            ], 200);
        }

        $response = $next($request);

        $headers = $this->getHeaders();

        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }

    protected function getHeaders()
    {
        return [
            'Access-Control-Allow-Origin' => config('app.cors.origin')[0], //@TODO allow multiple origins
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With'
        ];
    }
}
