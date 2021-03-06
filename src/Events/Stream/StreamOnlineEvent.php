<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Stream;

use Carbon\CarbonInterface;
use katzen48\Twitch\EventSub\Events\BaseEvent;
use romanzipp\Twitch\Enums\EventSubType;

class StreamOnlineEvent extends BaseEvent
{
    protected static string $type = EventSubType::STREAM_ONLINE;

    protected static string $version = '1';

    public string $streamId;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public string $streamType;

    public CarbonInterface $startedAt;

    public function parseEvent($event): void
    {
        $this->streamId = $event['id'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->streamType = $event['type'];
        $this->startedAt = $this->parseCarbon($event['started_at']);
    }

    public static function subscribe(string $broadcasterId, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo(self::getVersion(), [
            'broadcaster_user_id' => $broadcasterId,
        ], false, $callbackUrl);
    }
}
