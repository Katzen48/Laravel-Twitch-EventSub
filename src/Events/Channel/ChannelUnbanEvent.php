<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel;

use katzen48\Twitch\EventSub\Events\BaseEvent;

class ChannelUnbanEvent extends BaseEvent
{
    public string $unbannedId;

    public string $unbannedLogin;

    public string $unbannedName;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public string $moderatorId;

    public string $moderatorLogin;

    public string $moderatorName;

    public function parseEvent($event): void
    {
        $this->unbannedId = $event['user_id'];
        $this->unbannedLogin = $event['user_login'];
        $this->unbannedName = $event['user_name'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->moderatorId = $event['moderator_user_id'];
        $this->moderatorLogin = $event['moderator_user_login'];
        $this->moderatorName = $event['moderator_user_name'];
    }
}
