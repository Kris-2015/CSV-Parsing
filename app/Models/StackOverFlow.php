<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use QueryException;

class StackOverFlow extends Model
{
    protected $table = 'stackoverflow';

    public static function empStackInfo($stackInfo)
    {
        try
        {
            $objStackInfo = new StackOverFlow();

            $objStackInfo->emp_id = $stackInfo['empid'];
            $objStackInfo->stack_id = $stackInfo['stack_id'];
            $objStackInfo->stack_nickname = $stackInfo['stack_nickname'];
            $successInfo = $objStackInfo->save();

            if ($successInfo)
            {
                return $successInfo;
            }

            throw new QueryException('error occured at stack over flow table');
        }
        catch (QueryException $error)
        {
            errorReport($error);
            return 0;
        }
    }
}
