<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

/**
 * Model for reports table
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class Report extends Model
{
    /** Defining the table name of the model */
    protected $table = 'reports';

    /**
     * Function to update report table where users report is ready
     *
     * @param: uri
     * @param: user id
     * @return: integer
     * @throws: Query Exception
     */
    public static function insertReportInfo($uri, $userId)
    {
        try
        {
            // Instantiate the Report class
            $objReport = new Report();

            // Insert the user id and Uri of report
            $objReport->user_id = $userId;
            $objReport->uri = $uri;
            $successReport = $objReport->save();

            if ( ! $successReport )
            {
                throw new QueryException('Error occured with inserting report data');
            }

            return $successReport;
        }
        catch ( QueryException $e )
        {
            // Log error
            errorReporting($e);

            return 0;
        }
    }

    /**
     * Function to update report status
     *
     * @param: report status
     * @param: user id
     * @return: integer
     * @throws: Query Exception
     */
    public static function updateReportStatus($userId, $status)
    {
        try
        {
            // Update the report status of the user by user id
            $updateReport = Report::where('user_id', $userId)
                ->update(['report_status' => $status ]);

            // throw exception if query fails
            if ( ! $updateReport )
            {
                throw new QueryException("Error occured while updating the ");
            }

            return $updateReport;
        }
        catch(QueryException $e)
        {
            // Log error
            errorReporting($e);

            // return 0 on error occured
            return 0;
        }
    }
}
