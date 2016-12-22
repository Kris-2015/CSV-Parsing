<?php

use Illuminate\Support\Facades\Log;

/**
 * This file is responsible to keep all the global functions.
 *
 * @access public
 * @package App\Helpers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */

/**
 * Function to generate random number
 *
 * @param: void
 * @return: integer
 */
function generateNumber()
{
   // Return random gerenrated number
   return rand(10, 100);
}

/**
 * Function to log errors
 *
 * @param: error
 * @return: void
 */
function errorReporting($error)
{
    Log::error($error);
}

/**
 * Function to convert any boolean to integer
 *
 * @param: string / integer
 * @return: integer
 */
function booleanToInt($value)
{

    $dictionary = array(
        '0' => 0,
        '1' => 1,
        'true' => 1,
        'false' => 0
    );
    
    if ( array_key_exists( $value, $dictionary) )
    {
        return $dictionary[$value];    
    }
    
    return 0;
}