<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Stream;

use katzen48\Twitch\EventSub\Events\BaseEvent;

class StreamOfflineEvent extends BaseEvent
{
    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public function parseEvent($event): void
    {
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
    }
}
