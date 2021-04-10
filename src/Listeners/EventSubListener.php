<?php

namespace katzen48\Twitch\EventSub\Listeners;

use katzen48\Twitch\EventSub\Events\EventParser;

/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:09 PM
 */
class EventSubListener
{
    public function handle(\romanzipp\Twitch\Events\EventSubReceived $eventSub)
    {
        $event = EventParser::parse($eventSub->payload);

        $event::dispatch($eventSub->payload);
    }
}