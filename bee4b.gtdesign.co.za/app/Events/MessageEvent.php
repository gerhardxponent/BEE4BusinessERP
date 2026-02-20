<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recipient_id;
    public $message_id;
    public $chat_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($recipient_id, $message_id, $chat_id)
    {
        $this->recipient_id = $recipient_id;
        $this->message_id = $message_id;
        $this->chat_id = $chat_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new Channel('chat.' . $this->recipient_id);
        return new Channel('chat.' . $this->chat_id);
    }
}
