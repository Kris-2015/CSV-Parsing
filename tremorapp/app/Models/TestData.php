<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

/**
 * Model for test_data table
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */

class TestData extends Model
{

    // Defining the table name of the model
    protected $table= 'test_data';
    public $timestamps = false;

    /**
     * Function to insert the test results
     *
     * @param: accelerometer data
     * @param: test id
     * @return: integer
     * @throws: Query Exception
     */
    public static function insertTestResult($data)
    {
        try
        {              
            // Setting up the deltaT variable to 0
            $deltaT = 0;

            $insertData = array();

            // Perform bulk insertion of acceleration data
            foreach ($data['accelerationData'] as $index => $acc_data)
            {
                $insertData[$index] = array(
                    'test_id' => $data['test_id'],
                    'accel_x' => $acc_data['x'],
                    'accel_y' => $acc_data['y'],
                    'accel_z' => $acc_data['z'],
                    't' => ($index == 0) ? 0: ($deltaT + round($acc_data['t'] * 1000))
                );

                if ( $index != 0 )
                {
                    $deltaT += round($acc_data['t'] * 1000);
                }
            }

            // Perform bulk insertion of acceleration data
            $successTestData = TestData::insert($insertData);

            // Return 1 on successfully inserting the acceleration data
            if ($successTestData)
            {
                return $successTestData;
            }

            throw new QueryException("Error occured while inserting test data");
        }
        catch (QueryException $e)
        {
            // Log error
            errorReporting($e);

            // Return false on error occured
            return 0;
        }
    }
}