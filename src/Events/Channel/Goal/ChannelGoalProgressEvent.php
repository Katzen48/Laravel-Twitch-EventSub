<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel\Goal;

use Carbon\CarbonInterface;
use katzen48\Twitch\EventSub\Events\BaseEvent;

class ChannelGoalProgressEvent extends BaseEvent
{
    public string $id;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public string $type;

    public string $description;

    public bool $achieved;

    public int $currentAmount;

    public int $targetAmount;

    public CarbonInterface $startedAt;

    public function parseEvent($event): void
    {
        $this->id = $event['id'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->type = $event['type'];
        $this->description = $event['description'];
        $this->achieved = $event['is_achieved'];
        $this->currentAmount = $event['current_amount'];
        $this->targetAmount = $event['target_amount'];
        $this->startedAt = $this->parseCarbon($event['started_at']);
    }

    public function isFollower(): bool
    {
        return $this->type === 'follower';
    }

    public function isSubscription(): bool
    {
        return $this->type === 'subscription';
    }

    public function isNewSubscription(): bool
    {
        return $this->type === 'new_subscription';
    }
}
