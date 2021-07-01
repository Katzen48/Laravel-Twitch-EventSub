<?php
/**
 * User: Katzen48
 * Date: 4/9/2021
 * Time: 11:29 PM
 */

namespace katzen48\Twitch\EventSub\Facades;

use Illuminate\Support\Facades\Facade;
use katzen48\Twitch\EventSub\TwitchEventSub as TwitchEventSubService;

/**
 * Class TwitchEventSub
 * @package katzen48\Twitch\EventSub\Facades
 *
 * @method static string|null subscribeEvent(string $type, string $version, array $condition, bool $batching = false, string $callbackUrl = null)
 * @method static bool unsubscribeEvent(string $subscriptionId)
 */
class TwitchEventSub extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TwitchEventSubService::class;
    }
}