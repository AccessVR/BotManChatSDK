<?php

namespace OrchestrateXR\BotManChatSDK\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use OrchestrateXR\BotManChatSDK\BotManChat;
use OrchestrateXR\BotManChatSDK\BotManMessage;

class BotManMessageCreated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public BotManMessage $message;

    /**
     * Create a new event instance.
     */
    public function __construct(BotManMessage $message)
    {
        $this->message = $message;
    }

    public function broadcastAs(): string
    {
        return BotManChat::config('echoEventName');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(BotManChat::echoChannel()),
        ];
    }
}
