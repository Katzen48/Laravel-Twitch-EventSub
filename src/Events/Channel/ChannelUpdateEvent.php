<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:59 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel;

use katzen48\Twitch\EventSub\Events\BaseEvent;
use romanzipp\Twitch\Enums\EventSubType;

class ChannelUpdateEvent extends BaseEvent
{
    protected static string $type = EventSubType::CHANNEL_UPDATE;

    protected static string $version = '1';

    public string $userId;

    public string $login;

    public string $userName;

    public string $title;

    public string $language;

    public string $categoryId;

    public string $categoryName;

    public bool $mature;

    public function parseEvent($event): void
    {
        $this->userId = $event['broadcaster_user_id'];
        $this->login = $event['broadcaster_user_login'];
        $this->userName = $event['broadcaster_user_name'];
        $this->title = $event['title'];
        $this->language = $event['language'];
        $this->categoryId = $event['category_id'];
        $this->categoryName = $event['category_name'];
        $this->mature = $event['is_mature'];
    }

    public static function subscribe(string $broadcasterId, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo(self::getVersion(), [
            'broadcaster_user_id' => $broadcasterId,
        ], false, $callbackUrl);
    }
}
