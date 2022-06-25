<?php
/**
 * User: Katzen48
 * Date: 6/24/2022
 * Time: 10:57 PM
 */

namespace katzen48\Twitch\EventSub\Events;

trait HasEventType
{
    protected static string $type;

    public static function getType(): string
    {
        return self::$type;
    }
}
