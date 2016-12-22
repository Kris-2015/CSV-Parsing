<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Report;
use App\Http\Controllers\ReportController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Running task scheduling for every minute
        $schedule->call(function () {

            // Get the data based in report_status equal to 0 with limit 10
            $reportStatus = Report::where('report_status', 0)
                ->limit(env('LIMIT', '10'))
                ->get();

            foreach( $reportStatus as $user )
            {
                // Call the sendReportComplete of Report Controller to send email to the user 
                ReportController::sendReportComplete($user['user_id']);    
            }

        })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}