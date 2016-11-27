<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use QueryException;

class HR extends Model
{
    protected $table = 'hr';

    public static function insertHrName($hr)
    {
        try
        {
            $objHr = new HR();

            $objHr->name = $hr;
            $successHr = $objHr->save();

            if ($successHr)
            {
                // Return last insert id
                return $objHr->id;
            }

            throw new QueryException('Error occured while insertion in HR table');
        }
        catch (QueryException $e)
        {
            errorReport($e);
            return 0;
        }
    }
}
