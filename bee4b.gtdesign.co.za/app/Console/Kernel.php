<?php

namespace App\Console;

use App\Console\Commands\EmailCommand;
use App\Jobs\SendEmails;
use App\Jobs\TestJob;
use App\Models\BoardItem;
use App\Models\ScheduledReport;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // To start scheduler run 'php artisan schedule:work'

        $schedule->call(function() {
            BoardItem::query()
                ->where([
                    ['deadline', '<', Carbon::now()],
                    ['deadline', '!=', null],
                    ['status', '!=', 'complete'],
                ])
                ->update(['overdue' => 1]);
        })->dailyAt('6:00');

        $schedule->command('leads:send-followup-emails')->dailyAt('08:00');
        $schedule->command('leads:auto-archive')->dailyAt('08:15');
        
        // $schedule->command('command:email')->everyMinute();

        // $data = DB::table('scheduled_commands')->pluck('schedule_time')->first();

        // $schedule->job(new TestJob())->dailyAt('9:10');

        // if ($data === 'everyMinute') {
        //     $schedule->job(new TestJob())->everyMinute();
        // } else {
        //     $schedule->job(new TestJob())->daily();
        // }


        // $schedule->job(new SendEmails())->everyMinute();

        // $schedule->call(function() {
        //     DB::unprepared('INSERT INTO test(name) VALUES("test")');
        // })->everyMinute();

        // $schedule->command('command:name')->everyMinute();

        // $data = DB::table('commands')->pluck('run')->first();

        // if($data == '1') {
        //     $schedule->command('command:email')->everyMinute();
        // }else if($data == '2') {
        //     $schedule->command('command:email')->everyTwoMinutes();
        // }else if($data == '3') {
        //     $schedule->command('command:email')->everyThreeMinutes();
        // }

        // $sr = ScheduledReport::all();
        // foreach($sr as $r) {
        //     $reportName = $r->report()->pluck('name')->first();
        //     $schedule->command('command:email ' . $reportName . ' ' . $r->email)->cron($r->cron);
        // }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected $commands = [
        \App\Console\Commands\SendLeadFollowUpEmails::class,
    ];
}
