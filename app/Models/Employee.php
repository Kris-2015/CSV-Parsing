<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use QueryException;

class Employee extends Model
{
    public static function insertEmployee($empdata)
    {
        try
        {
            $emp = new Employee();
            // Insert employee details
            $emp->emp_id = $empdata['empid'];
            $emp->first_name = $empdata['first_name'];
            $emp->last_name = $empdata['last_name'];
            $emp->created_by = $empdata['created_by'];
            $emp->updated_by = $empdata['updated_by'];
            $success = $emp->save();

            // After successful entry in employee table
            if ($success)
            {
               // return employee id
                return $emp->id;
            }

            throw new QueryException('error occured at employee table');
        }
        catch (QueryException $error)
        {
            errorReport($error);
            return 0;
        }
    }
}
