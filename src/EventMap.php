<?php

namespace katzen48\Twitch\EventSub;

/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:07 PM
 */
trait EventMap
{
    protected $events = [
        \romanzipp\Twitch\Events\EventSubReceived::class => [
            \katzen48\Twitch\EventSub\Listeners\EventSubListener::class,
        ],
    ];
}
