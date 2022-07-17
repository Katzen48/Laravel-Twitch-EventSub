<?php
/**
 * User: Katzen48
 * Date: 6/24/2022
 * Time: 10:57 PM
 */

namespace katzen48\Twitch\EventSub\Traits;

trait HasScopes
{
    protected static array $scopes = [];

    /***
     * Returns the required scopes.
     * One of the returned scopes is sufficient to subscribe to the topic.
     * @return array required scopes
     */
    public static function getScopes(): array
    {
        return static::$scopes;
    }
}
