<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel;

use katzen48\Twitch\EventSub\Events\BaseEvent;

class ChannelCheerEvent extends BaseEvent
{
    public bool $anonymous;

    public string $cheererId;

    public string $cheererLogin;

    public string $cheererName;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public string $message;

    public int $bits;

    public function parseEvent($event): void
    {
        $this->anonymous = $event['is_anonymous'];
        $this->cheererId = $event['user_id'];
        $this->cheererLogin = $event['user_login'];
        $this->cheererName = $event['user_name'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->message = $event['message'];
        $this->bits = $event['bits'];
    }
}