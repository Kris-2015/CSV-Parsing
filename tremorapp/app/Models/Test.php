<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TestData;
use Exception;
use DB;

/**
 * Model for test table
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class Test extends Model
{

    // Defining the table name of the model
    protected $table= 'tests';
    public $timestamps = false;
    protected static $testComplete = 'test_complete';
    protected static $userId = 'user_id';
    protected static $ordinal = 'ordinal';
    protected static $posture = 'posture';
    protected static $token = 'token';
    protected static $startTime = 'start_time';

    /**
     * Function to insert test type information
     *
     * @param test type
     * @return signed integer
     * @throws: Query Exception
     */
    public static function insertTestData($data)
    {
        try
        {
            // Default return value
            $response = 0;

           // Get the user status by token
           $getUserStatus = User::find($data[static::$token]);

           // Insert test record if test complete is 0
           if ($getUserStatus[static::$testComplete] == 0)
           {
                // Update the users table of test complete with current request value
                User::updateTestComplete($data);

                // Check the existance of the incoming test record by user id, ordinal and posture
                $check = Test::where([
                    [ static::$userId,  '=', $data[static::$token] ],
                    [ static::$ordinal, '=', $data[static::$ordinal] ],
                    [ static::$posture,  '=', $data[static::$posture] ]
                ])->get();

                // If there is no previous record present, proceed for insertion
                if ( $check->isEmpty() )
                {
                    
                    // Instantiate the Test class
                    $objTest = new Test();

                    $objTest->user_id = $data[static::$token];
                    $objTest->posture = $data[static::$posture];
                    $objTest->ordinal = $data[static::$ordinal];
                    $objTest->start_time = $data[static::$startTime];
                    $successTest = $objTest->save();

                    // On successful insertion, proceed with accelerometer data
                    if ( $successTest )
                    {
                        // Associate the test id and acceleration data
                        $testData = array(
                            'test_id' => $objTest->id,
                            'accelerationData' => $data['acceleration_data']
                        );

                        // Insert the test data
                        $successTestData = TestData::insertTestResult($testData);

                        $response = ($successTestData == 1) ? $successTestData : 0;
                    }
                }
                else
                {
                    // Duplicate entry of test data
                    $response = -1;
                }
            }
            else
            {
                // Return -2 as test is already complete
                $response = -2;
            }
        }
        catch (QueryException $e)
        {
            // Logging error
            errorReporting($e);

            // Return false as error has occured
            $response = 0;
        }

        return $response;
    }
}