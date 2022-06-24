<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel;

use Carbon\CarbonInterface;
use katzen48\Twitch\EventSub\Events\BaseEvent;
use romanzipp\Twitch\Enums\EventSubType;

class ChannelFollowEvent extends BaseEvent
{
    public const type = EventSubType::CHANNEL_FOLLOW;

    public string $followerId;

    public string $followerLogin;

    public string $followerName;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public CarbonInterface $followedAt;

    public function parseEvent($event): void
    {
        $this->followerId = $event['user_id'];
        $this->followerLogin = $event['user_login'];
        $this->followerName = $event['user_name'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->followedAt = $this->parseCarbon($event['followed_at']);
    }

    public function subscribe(string $broadcasterId, string $callbackUrl = null): ?string
    {
        return \katzen48\Twitch\EventSub\Facades\TwitchEventSub::subscribeEvent(self::type, '1', [
            'broadcaster_user_id' => $broadcasterId,
        ], false, $callbackUrl);
    }
}
