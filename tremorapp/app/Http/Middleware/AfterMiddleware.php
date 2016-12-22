<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Logs the responses in the request log file
 *
 * @access public
 * @package App\Http\Middleware
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class AfterMiddleware
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
        // Store the response data
        $response = $next($request);

        // Log request when debugging is enabled
        if ( env('ENABLE_DEBUGGING') == 1)
        {            
            // Write the response data to the server
            $file = fopen(storage_path('logs/request.log'), 'a');
            fwrite($file, date('d/m/Y h:i:s A', time())."\r \n");
            fwrite($file, $response);
            fclose($file);
        }

        return $response;
    }
}
