<?php
/**
 * Created by PhpStorm.
 * User: krishnadev
 * Date: 17/11/16
 * Time: 12:21 PM
 */
use Illuminate\Support\Facades\Log;

/**
 * Function to log errors
 *
 * @param error
 * @return void
 */
function errorReport($error)
{
    Log::error($error);
}

/**
 * Dictionary function which converts hr name to number
 *
 * @param string
 * @return integer
 */
function hrDictionary($name)
{
    $hrName = array(
        'AS' => '1',
        'MC' => '2',
        'SL' => '3'
    );

    if(array_key_exists($name, $hrName))
    {
        return $hrName[$name];
    }

    return 1;
}

/**
 * Dictionary function which converts skills name to number
 *
 * @param string
 * @return integer
 */
function Dictionary($skill)
{
    $skillDictionary = array(
        'jQuery' => '1',
        'Perl' => '2',
        'Nginx' => '3',
        'Memcached' => '4',
        'Nosql' => '5',
        'mongodb' => '6',
        'redis' => '7',
        'node.js' => '8',
        'agile' => '9',
        'Jira' => '10',
        'Scrum' => '11',
        'HTML5' => '12',
        'javascript' => '13',
        'Laravel' => '14',
        'PHP' => '15',
        'MySQL' => '16',
        'Python' => '17'
    );

    if(array_key_exists($skill, $skillDictionary))
    {
        return $skillDictionary[$skill];
    }

    return 1;
}