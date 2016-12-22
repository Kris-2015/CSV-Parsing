<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use App\Models\Report;
use Mail;

/**
 * Helper file constains the independent function 
 * of laravel
 *
 * @access public
 * @package App\Helpers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class Helper extends Model
{
    /**
     * Function to sen mail to client
     *
     * @param: personal mail id
     * @param: doctor mail id
     * @param: research organisation mail id
     * @return: integer
     */
    public static function sendMail($data = array())
    {
        // Assisgn default value in bcc and cc as empty array
        $cc_address = [];
        $bcc_address = [];

        // Assign research_org_email and doctors email if value present
        if ( $data['research_org_email'] )
        {
            $bcc_address[0] = $data['research_org_email'];
        }
        
        if ( $data['doctors_email'] )
        {
            $cc_address[0] = $data['doctors_email'];
        }

        // Perform Mail Operation
        Mail::queue("emails.sample", ['data' => $data], function($msg) use($data, $cc_address, $bcc_address) {
                $msg->to($data['personal_email'])
                    ->cc($cc_address)
                    ->bcc($bcc_address)
                    ->subject('Tremor Test Report');
            });

        // Update the report status to 1 as email has been sent to user
        Report::updateReportStatus($data['id'], env('EMAIL_STATUS'));
    }
}
