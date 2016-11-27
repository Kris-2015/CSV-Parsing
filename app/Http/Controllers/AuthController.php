<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Skill;
use App\Models\SkillKnown;
use App\Models\HR;
use App\Models\StackOverFlow;
use DB;

/*
 * Controller to handle the csv file request
 * @package app/Http/Controller
 */
class AuthController extends Controller
{
    /**
     * Function to parse csv file
     *
     * @param $request
     * @return string
     */
    public function example(Request $request)
    {
        // CSV file name
        $csvFile = env('CSV_FILE', 'Parse_Sheet.csv');

        // Initialised empty array
        $hrValue = array();
        $skillValue = array();

        // Check if file exists
        if (file_exists($csvFile))
        {
            // Convert the csv file data into associative array
            $csv = array_map('str_getcsv', file(public_path($csvFile)));

            // Begin parsing of csv file data
            foreach($csv as $index => $data)
            {
                // Ignore the first array
                if ($index != 0)
                {
                    // Convert string into array and remove semicolon
                    $semicolonFree = explode(";", $data[0]);

                    // Store the hr name
                    $hr = array(
                        $semicolonFree[10],
                        $semicolonFree[11]
                    );

                    // Insert hr name
                    foreach($hr as $hrName)
                    {
                        // Get the name of hr if exist
                        $getHr = HR::where('name', $hrName)->get();

                        // Insert if there is no record
                        if ($getHr->isEmpty())
                        {
                            // Store the HR details
                            $hrId = HR::insertHrName($hrName);
                            $hrValue[$hrName] = $hrId;
                        }
                    }

                    // Store the skills of employee
                    $skills = array(
                        $semicolonFree[3],
                        $semicolonFree[4],
                        $semicolonFree[5],
                        $semicolonFree[6],
                        $semicolonFree[7]
                    );

                    // Insert the skill name into the table
                    foreach($skills as $empSkill)
                    {
                        // Avoid insertion if any column value is empty
                        if (!empty($empSkill))
                        {
                            // Check for skill record
                            $getSkills = Skill::where('name', $empSkill)->get();

                            // if the record is new, insert it
                            if ($getSkills->isEmpty())
                            {
                                // Insert skills
                                $skillId = Skill::insertSkills($empSkill);
                                $skillValue[$empSkill] = $skillId;
                            }
                        }
                    }

                    // Store the employee information
                    $employeeDetail = array(
                        'empid' => $semicolonFree[0],
                        'first_name' => $semicolonFree[1],
                        'last_name' => $semicolonFree[2],
                        'created_by' => $hrValue[$semicolonFree[10]],
                        'updated_by' => $hrValue[$semicolonFree[11]]
                    );

                    // Insert the employee information and get last inserted skill id
                    $getEmployeeId = Employee::insertEmployee($employeeDetail);

                    // Form the relationship of skill and employee on the basis of skill id
                    foreach($skills as $data)
                    {
                        if ( ! empty($data) )
                        {
                            // Assosciate the employee id and skill id in array
                            $skillEmployee = array(
                                'emp_id' => $getEmployeeId,
                                'skill_id' => $skillValue[$data]
                            );

                            // Insert the employee and skill relation
                            SkillKnown::insertEmployeeSkills($skillEmployee);
                        }
                    }

                    // Check if stack id is present
                    if (isset($semicolonFree[8]))
                    {
                        // Assosciate the employee's stackoverflow information wrt employee id
                        $userStack = array(
                            'empid' => $getEmployeeId,
                            'stack_id' => $semicolonFree[8],
                            'stack_nickname' => $semicolonFree[9]
                        );

                        // Insert the StackOverFlow Information of employee
                        StackOverFlow::empStackInfo($userStack);
                    }
                }
            }
        }
        else
        {
            return 'file does not exist';
        }

        return 'data inserted successfully';
    }

    /**
     * Function to display the csv file data
     *
     * @param $request
     * @return view
     */
    public function display(Request $request)
    {
        // Get the employee record
        $getEmployee = Employee::join('skills_known', $this->employeeId, '=', 'skills_known.emp_id')
            ->join('skills', 'skills_known.skill_id', '=', 'skills.id')
            ->join('hr', 'employees.created_by', '=', 'hr.id')
            ->join('hr AS hr1', 'employees.updated_by', '=', 'hr1.id')
            ->leftJoin('stackoverflow AS st', $this->employeeId, '=', 'st.emp_id')
            ->select(['employees.emp_id', 'employees.first_name', 'employees.last_name',
                DB::raw('GROUP_CONCAT(skills.name) AS skills'),
            'st.stack_id', 'st.stack_nickname', 'hr.name AS created_by', 'hr1.name AS updated_by'
            ])
            ->groupBy($this->employeeId)
            ->get();

        // return the view with table structure
        return view('pages.display',['employee' => $getEmployee]);
    }
}
