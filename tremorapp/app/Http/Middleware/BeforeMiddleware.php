<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Logs the incoming request in the request log file
 *
 * @access public
 * @package App\Http\Middleware
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class BeforeMiddleware
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
        // Log request when debugging is enabled
        if ( env('ENABLE_DEBUGGING') == '1')
        {
            // Save the incoming input request to request file
            $file = fopen(storage_path('logs/request.log'), 'a');
            fwrite($file, date('d/m/Y h:i:s A', time())."\r \n");
            fwrite($file, $request);
            fclose($file);    
        }

        return $next($request);
        
    }
}
