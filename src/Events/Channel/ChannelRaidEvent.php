<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel;

use katzen48\Twitch\EventSub\Events\BaseEvent;

class ChannelRaidEvent extends BaseEvent
{
    public string $fromBroadcasterId;

    public string $fromBroadcasterLogin;

    public string $fromBroadcasterName;

    public string $toBroadcasterId;

    public string $toBroadcasterLogin;

    public string $toBroadcasterName;

    public int $viewers;

    public function parseEvent($event): void
    {
        $this->fromBroadcasterId = $event['from_broadcaster_user_id'];
        $this->fromBroadcasterLogin = $event['from_broadcaster_user_login'];
        $this->fromBroadcasterName = $event['from_broadcaster_user_name'];
        $this->toBroadcasterId = $event['to_broadcaster_user_id'];
        $this->toBroadcasterLogin = $event['to_broadcaster_user_login'];
        $this->toBroadcasterName = $event['to_broadcaster_user_name'];
        $this->viewers = $event['viewers'];
    }
}
