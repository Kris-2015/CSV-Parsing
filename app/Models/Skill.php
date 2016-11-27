<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use QueryException;

class Skill extends Model
{
    /**
     *
     */
    public static function insertSkills($data)
    {
        try
        {
            $objSkills = new Skill();

            $objSkills->name = $data;
            $successSkill = $objSkills->save();

            if ($successSkill)
            {
                return $objSkills->id;
            }

            throw new QueryException('Error occured in Skill table');
        }
        catch (QueryException $error)
        {
            errorReport($error);
            return 0;
        }
    }
}
