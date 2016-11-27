<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use QueryException;

class SkillKnown extends Model
{
    protected $table = 'skills_known';

    public static function insertEmployeeSkills($data)
    {
        try
        {
            $skillEmployee = new SkillKnown();
            $skillEmployee->skill_id = $data['skill_id'];
            $skillEmployee->emp_id = $data['emp_id'];
            $successSkillEmployee = $skillEmployee->save();

            if ($successSkillEmployee)
            {
                return $successSkillEmployee;
            }
            throw new QueryException('error occured at skill employee table');
        }
        catch(QueryException $error)
        {
            errorReport($error);
            return 0;
        }
    }
}
