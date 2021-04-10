<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:59 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel;

use katzen48\Twitch\EventSub\Events\BaseEvent;

class ChannelUpdateEvent extends BaseEvent
{
    public string $uerId;

    public string $login;

    public string $userName;

    public string $title;

    public string $language;

    public string $categoryId;

    public string $categoryName;

    public bool $mature;

    public function parseEvent($event): void
    {
        $this->uerId = $event['broadcaster_user_id'];
        $this->login = $event['broadcaster_user_login'];
        $this->userName = $event['broadcaster_user_name'];
        $this->title = $event['title'];
        $this->language = $event['language'];
        $this->categoryId = $event['category_id'];
        $this->categoryName = $event['category_name'];
        $this->mature = $event['is_mature'];
    }
}