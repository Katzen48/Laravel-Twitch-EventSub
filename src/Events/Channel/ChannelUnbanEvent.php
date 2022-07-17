<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel;

use katzen48\Twitch\EventSub\Events\BaseEvent;
use romanzipp\Twitch\Enums\EventSubType;
use romanzipp\Twitch\Enums\Scope;

class ChannelUnbanEvent extends BaseEvent
{
    protected static string $type = EventSubType::CHANNEL_UNBAN;

    protected static string $version = '1';

    protected static array $scopes = [
        Scope::CHANNEL_MODERATE,
    ];

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

    public static function subscribe(string $broadcasterId, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo(self::getVersion(), [
            'broadcaster_user_id' => $broadcasterId,
        ], false, $callbackUrl);
    }
}
