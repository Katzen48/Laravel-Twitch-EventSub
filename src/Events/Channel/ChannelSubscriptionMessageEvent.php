<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel;

use katzen48\Twitch\EventSub\Events\BaseEvent;

class ChannelSubscriptionMessageEvent extends BaseEvent
{
    public string $subscriberId;

    public string $subscriberLogin;

    public string $subscriberName;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public string $tier;

    public mixed $message;

    public int $cumulativeMonths;

    public int $streakMonths;

    public int $durationMonths;

    public function parseEvent($event): void
    {
        $this->subscriberId = $event['user_id'];
        $this->subscriberLogin = $event['user_login'];
        $this->subscriberName = $event['user_name'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->tier = $event['tier'];
        $this->message = $event['message'];
        $this->cumulativeMonths = $event['cumulative_months'];
        $this->streakMonths = $event['streak_months'];
        $this->durationMonths = $event['duration_months'];
    }
}