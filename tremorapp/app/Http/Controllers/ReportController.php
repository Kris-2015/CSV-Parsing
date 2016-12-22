<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Helpers\Helper;
use App\Http\Requests;
use App\Http\Requests\ReportRequest;
use Exception;

/**
 * Handles the report request, download report
 *  and send an email to the user
 *
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class ReportController extends Controller
{
    /**
     * Function for showing the view file
     *
     * @param  token
     * @param  hash key
     * @return view
     */
    public function report(Request $request)
    {
        //Store the incoming data
        $getRequest = $request->all();

        //get token as user id and hash key
        $tId = isset($getRequest['token']) ? $getRequest['token'] : 0;
        $hId = isset($getRequest['key']) ? $getRequest['key'] : 1;

        // Verify the token and hash key
        $verifyRequest = User::join('reports', 'users.id', '=', 'reports.user_id')
        ->where([
            ['users.id', '=', $tId],
            ['users.hash_key', '=', $hId]
        ])->get();

        // Get the token id and hash key
        $url = array(
            $this->tokenId => $tId,
            $this->hashId => $hId
        );

        // If user id and hash key matches, show the report view
        if ( ! $verifyRequest->isEmpty() )
        {
            return view('get-report', ['url' => $url]);
        }
        
        // Redirect the invalid user to not allowed page
        return view('errors.not-allowed');
    }

    /**
     * Function for downloading the report
     *
     * @param  report id
     * @param  hash key as token
     * @return response
     * @throws file not found exception
     */
    public function authenticateUser(Request $request)
    {
        try 
        {
            // Store incoming request data
            $postRequest = $request->all();

            // Check whether pin is authentic
            $checkData = User::where([
                ['pin', '=', $postRequest['pin'] ],
                ['id', '=', $postRequest[$this->tokenId] ],
                ['hash_key', '=', $postRequest[$this->hashId]]
            ])->get();

            // If check data contains user information
            if ( ! $checkData->isEmpty() )
            {
                // Update the reports table report status to 2
                Report::updateReportStatus($checkData[0]['id'], env('DOWNLOAD_STATUS', '2'));

                // Get the report of user by user id
                $getReport = Report::where($this->userId, $checkData[0]['id'])
                    ->get();

                // Extract file name
                $name = trim(substr($getReport[0]['uri'], strrpos($getReport[0]['uri'], '/')+1), " \n\r");

                // Path of the file
                $pathToFile = preg_replace("/[^a-zA-Z0-9\/\.\_\-]+/", "", trim($getReport[0]['uri'], '\n\r'));

                // Check for existance of the file
                if ( ! file_exists($pathToFile) )
                {
                    throw new FileNotFoundException("Error Occured: File does not not exist");
                }     

                // Header content
                $headers = array(
                    'Content-Type: application/pdf',
                    'Content-Disposition:attachment; filename="$name"',
                    'Content-Transfer-Encoding:binary',
                    'Content-Length:'.filesize($pathToFile),
                );
                
                // Perform force download
                $response = response()->download($pathToFile, $name, $headers);   
            }
        } 
        catch (FileNotFoundException $e) 
        {
            // Log error for file not found
            errorReporting($e);

            // Return file does not exist
            $response = view('errors.does-not-exist');    
        }

        // Redirect response
        return $response;
    }

    /**
     * Function for downloading the report
     *
     * @param  report id
     * @param  hash key as token
     * @return response
     */
    public function validateUser(Request $request)
    {
        // Store incoming request data
        $postRequest = $request->all();

        // Redirect the user with error if data is invalid
        $response = response()->json(array(
            'error' => 'Incorrect pin.'
        ));

        // Check whether pin is authentic
        $checkData = User::where([
            ['pin', '=', $postRequest['pin'] ],
            ['id', '=', $postRequest[$this->tokenId] ],
            ['hash_key', '=', $postRequest[$this->hashId]]
        ])->get();

        // If check data contains user information
        if ( ! $checkData->isEmpty() )
        {
            // Get the report of user by user id
            $getReport = Report::where($this->userId, $checkData[0]['id'])
                ->get();

            // Path of the file
            $pathToFile = preg_replace("/[^a-zA-Z0-9\/\.\_\-]+/", "", trim($getReport[0]['uri'], '\n\r'));

            if ( ! file_exists($pathToFile) )
            {
                // Return file does not exist
                $response = response()->json(array(
                    'file' => 'Report is under processing. Please try again later'
                ));
            }
            else
            {
                // Return response for the correct pin number
                $response = response()->json(array(
                    'success' => 'correct pin'
                ));
            }
        } 
        
        // Redirect response to the user
        return $response;
    }

    /**
     * Function to update the report table with report complete
     *
     * @param  report uri
     * @param  user id
     * @return integer
     */
    public static function getReportComplete(Request $request)
    {
        // Get all the request data
        $getIncomingRequest = $request->all();

        // Get the uri and userId
        $uri = $getIncomingRequest['uri'];
        $userId = $getIncomingRequest['user_id'];
        
        // Insert the uri and user id
        $insertCompleteReport = Report::insertReportInfo($uri, $userId);

        // Default return value
        $status = 0;

        // Call send report if insertCompleteReport
        if ( $insertCompleteReport )
        {
            
            // Calling the send report complete function
            static::sendReportComplete($userId);

            // return success
            $status = 1;
        }
        
        // return failure
        return $status;
    }

    /**
     * Function to inform user that report is ready
     *
     * @param  Request
     * @return response
     */ 
    public static function sendReportComplete($userId)
    {
        // Get all the information based on user id
        $getEmailAddress = User::find($userId);

        // Send email to the user
        Helper::sendMail($getEmailAddress);

        return 1;
    }
}