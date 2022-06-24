<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use katzen48\Twitch\EventSub\Events\BaseEvent;

class ChannelBanEvent extends BaseEvent
{
    public string $bannedId;

    public string $bannedLogin;

    public string $bannedName;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public string $moderatorId;

    public string $moderatorLogin;

    public string $moderatorName;

    public string $reason;

    public CarbonInterface $bannedAt;

    public CarbonInterface $endsAt;

    public bool $permanent;

    public function parseEvent($event): void
    {
        $this->bannedId = $event['user_id'];
        $this->bannedLogin = $event['user_login'];
        $this->bannedName = $event['user_name'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->moderatorId = $event['moderator_user_id'];
        $this->moderatorLogin = $event['moderator_user_login'];
        $this->moderatorName = $event['moderator_user_name'];
        $this->reason = $event['reason'];
        $this->bannedAt = $this->parseCarbon($event['banned_at']);
        $this->endsAt = $this->parseCarbon($event['ends_at']);
        $this->permanent = $event['is_permanent'];
    }
}