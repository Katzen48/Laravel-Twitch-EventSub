<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel;

use Illuminate\Support\Carbon;
use katzen48\Twitch\EventSub\Events\BaseEvent;

class ChannelModeratorAddEvent extends BaseEvent
{
    public string $moderatorId;

    public string $moderatorLogin;

    public string $moderatorName;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;


    public function parseEvent($event): void
    {
        $this->moderatorId = $event['user_id'];
        $this->moderatorLogin = $event['user_login'];
        $this->moderatorName = $event['user_name'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
    }
}