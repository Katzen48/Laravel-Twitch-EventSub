<?php

namespace katzen48\Twitch\EventSub\Listeners;

use katzen48\Twitch\EventSub\Events\EventParser;
use romanzipp\Twitch\Events\EventSubReceived;

/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:09 PM
 */
class EventSubListener
{
    public function handle(EventSubReceived $eventSub)
    {
        /**
         * @var $event \Illuminate\Foundation\Events\Dispatchable
         */
        $event = EventParser::parse($eventSub->payload);

        $event::dispatch($eventSub->payload, $eventSub->id, $eventSub->retries, $eventSub->timestamp);
    }
}
