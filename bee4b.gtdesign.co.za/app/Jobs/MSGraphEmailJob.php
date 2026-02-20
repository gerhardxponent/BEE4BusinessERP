<?php

namespace App\Jobs;

use App\TokenStore\TokenCache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Microsoft\Graph\Graph;
use Throwable;

class MSGraphEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $graph, $attendees, $name, $details, $start, $end;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($graph, $attendees, $name, $details, $start, $end)
    {
        $this->graph = $graph;
        $this->attendees = $attendees;
        $this->name = $name;
        $this->details = $details;
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $graph = $this->getGraph();

        $recipients = [];

        foreach ($this->attendees as $email) {
            array_push($recipients, ['emailAddress' => [
                'address' => $email,
            ]]);
        }

        $newEvent = [
            'subject' => $this->name,
            "body" => [
                "contentType" => "HTML",
                "content" => $this->details
            ],
            'start' => [
                'dateTime' => $this->start,
                'timeZone' => "South Africa Standard Time"
            ],
            'end' => [
                'dateTime' => $this->end,
                'timeZone' => "South Africa Standard Time"
            ],
            "attendees" => $recipients
        ];

        // try{
            // $graph = $this->getGraph();

            $response = $this->graph->createRequest('POST', '/me/events')
                ->attachBody($newEvent)
                ->setReturnType(Model\Event::class)
                ->execute();

            // dd($response);
        // } catch(Throwable $e) {
        //     Log::error($e);
        // }
    }
}
