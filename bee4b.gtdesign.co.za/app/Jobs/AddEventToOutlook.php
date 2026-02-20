<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Microsoft\Graph\Model;

class AddEventToOutlook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $graph;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $graph)
    {
        $this->data = $data;
        $this->graph = $graph;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $attendeeAddresses = explode(';', $this->data['eventAttendees']);
        $attendees = [];

        foreach($attendeeAddresses as $attendeeAddress) {
            array_push($attendees, [
                'emailAddress' => [
                    'address' => $attendeeAddress
                ],
                'type' => 'required'
            ]);
        }

        $newEvent = [
            'subject' => $this->data['eventSubject'],
            "body" => [
                "contentType" => "HTML",
                "content" => $this->data["eventBody"]
            ],
            'start' => [
                'dateTime' => $this->data['eventStart'],
                'timeZone' => "South Africa Standard Time"
            ],
            'end' => [
                'dateTime' => $this->data['eventEnd'],
                'timeZone' => "South Africa Standard Time"
            ],
            "attendees" => $attendees
        ];

        $response = $this->graph->createRequest('POST', '/me/events')
            ->attachBody($newEvent)
            ->setReturnType(Model\Event::class)
            ->execute();
    }
}
