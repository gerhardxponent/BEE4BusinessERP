<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:email {report} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $to_email = 'keshav.badul06@gmail.com';

        Mail::send('mail', ['data' => 'This is a test email'], function($message) use ($to_email) {
            $message->to($to_email)
                    ->subject('test email');
        });

        // $tableData = DB::select(DB::raw("SELECT * FROM " . $this->argument('report')));

        // $to_name = 'Keshav';
        // $to_email = $this->argument('email');
        // // $data = array('name'=>"keshav", "body" => "A test mail");
        
        // Mail::send('mail', ['data' => $tableData], function($message) use ($to_name, $to_email) {
        //     $message->to($to_email, $to_name)
        //             ->subject('Laravel Test Mail');
        // });
    }
}
