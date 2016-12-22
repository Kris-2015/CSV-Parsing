<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

/**
 * Handle the validation of users data
 * @access public
 * @package App\Http\Middleware
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class ApiMiddleware
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

        // Store the data from incoming request
        $getRequest = $request->all();

        // Get token
        $checkToken = isset($getRequest['token']) ? $getRequest['token'] : '';

        // Check for the token
        if ( ! $checkToken )
        {
            // Check if device token is present
            $getDeviceToken = isset($getRequest['app_id']) ? $getRequest['app_id'] : '';

            // Expected Device Token
            $expectedDeviceToken = md5( env('TREMOR_SALT_KEY') );

            // Compare expected device token and get device token
            if ( $expectedDeviceToken === $getDeviceToken )
            {
                // Allow request to proceed
                return $next($request);
            }

        }
        else
        {
            // Get the token
            $token = $getRequest['token'];

            // Get device token
            $deviceToken = $getRequest['app_id'];

            // Get the hask key from users table
            $getHashKey = User::find($getRequest['token']);

            // Default device token
            $expectedAppToken = md5($getHashKey['hash_key'] . $token);
            
            // Process request if condition is true
            if ($expectedAppToken === $deviceToken)
            {
                // Allow request to move forward
                return $next($request);
            }

            // Return error response to invalid user
            return response()->json(array(
                'error' => '403',
                'message' => 'Unauthorised Request'
            ), 403);

        }

        // Return with invalid response message
        return response()->json( array(
            'status' => '403',
            'error' => 'Unauthorised Request'
        ), 403);
    }
}