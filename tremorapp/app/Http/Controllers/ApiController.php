<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\User;
use App\Models\Test;
use App\Http\Requests\UserRequest;

/**
 * Handles the api calls for sign up and test data request
 *
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */

class ApiController extends Controller
{
    /**
     * Function to submit user information
     *
     * @param  request
     * @return int
     */
    public function users(UserRequest $request)
    {
        // Get data after updating users information
        $data = User::insertUsers($request->all());

        // If data has some value, return the token
        if ( $data )
        {
            // Response Message with token
            return response()->json(array(
                $this->status => '200',
                $this->message => 'success',
                $this->data => array(
                    $this->token => $data[0],
                    $this->hashKey => $data[1]
                )
            ), 200);
        }

        // return 400 error, if tokenData does not have any value
        return response()->json(array(
            $this->status => '400',
            $this->error => 'Insufficient Parameter',
            $this->response => '0'
        ), 400);
    }
    
    /**
     * Function to submit user test data
     *
     * @param  request
     * @return int
     */
    public function data(Request $request)
    {
        // Calling insert test function insert test data 
        $testData = Test::insertTestData($request->all());

        // Array conatins all the data of response type
        $responseCollection = array (
            array(
                $this->status => '400',
                $this->error => 'Insufficient Parameter',
                $this->response => '0'
            ),
            $this->statusCode => '400'
        );

        // Return success response if test data is 1
        if ( $testData == 1 )
        {
            $responseCollection = array(
                array(
                    $this->status => '200',
                    $this->message => 'success',
                    $this->response => '1'
                ),
                $this->statusCode => '200'
            );
        }
        // message for duplicate entry
        else if ( $testData == -1 )
        {
            $responseCollection = array(
                array(
                    $this->status => '200',
                    $this->message => 'duplicate entry',
                    $this->response => '-1'
                ),
                $this->statusCode => '200'
            );
        }
        // message for test complete
        else if ( $testData == -2 )
        {
            $responseCollection = array(
                array(
                    $this->status => '200',
                    $this->message => 'The test is already been completed',
                    $this->response => '-1'
                ),
                $this->statusCode => '200'
            );
        }

        // Return error response if error occured
        return response()->json( $responseCollection[0], $responseCollection['statusCode']);
    }
}