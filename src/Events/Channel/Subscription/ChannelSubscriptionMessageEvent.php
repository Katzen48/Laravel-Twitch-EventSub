<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel\Subscription;

use katzen48\Twitch\EventSub\Events\BaseEvent;
use romanzipp\Twitch\Enums\EventSubType;
use romanzipp\Twitch\Enums\Scope;

class ChannelSubscriptionMessageEvent extends BaseEvent
{
    protected static string $type = EventSubType::CHANNEL_SUBSCRIPTION_MESSAGE;

    protected static string $version = '1';

    protected static array $scopes = [
        Scope::CHANNEL_READ_SUBSCRIPTIONS,
    ];

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

    public static function subscribe(string $broadcasterId, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo(self::getVersion(), [
            'broadcaster_user_id' => $broadcasterId,
        ], false, $callbackUrl);
    }
}
