<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Stream;

use katzen48\Twitch\EventSub\Events\BaseEvent;
use romanzipp\Twitch\Enums\EventSubType;

class StreamOfflineEvent extends BaseEvent
{
    protected static string $type = EventSubType::STREAM_OFFLINE;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public function parseEvent($event): void
    {
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
    }

    public static function subscribe(string $broadcasterId, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo('1', [
            'broadcaster_user_id' => $broadcasterId,
        ], false, $callbackUrl);
    }
}
