<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel;

use katzen48\Twitch\EventSub\Events\BaseEvent;

class ChannelSubscriptionGiftEvent extends BaseEvent
{
    public string $subscriberId;

    public string $subscriberLogin;

    public string $subscriberName;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public int $total;

    public string $tier;

    public int $cumulativeTotal;

    public bool $anonymous;

    public function parseEvent($event): void
    {
        $this->subscriberId = $event['user_id'];
        $this->subscriberLogin = $event['user_login'];
        $this->subscriberName = $event['user_name'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->total = $event['total'];
        $this->tier = $event['tier'];
        $this->cumulativeTotal = $event['cumulative_total'];
        $this->anonymous = $event['is_anonymous'];
    }
}