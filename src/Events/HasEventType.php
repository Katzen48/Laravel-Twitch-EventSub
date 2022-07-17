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
    protected static string $version;

    public static function getType(): string
    {
        return self::$type;
    }

    public static function getVersion(): string
    {
        return self::$version;
    }
}
