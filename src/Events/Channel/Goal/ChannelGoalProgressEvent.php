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
    protected static string $type = 'channel.goal.progress'; // TODO change to EventSubType::CHANNEL_GOAL_PROGRESS
    protected static string $version = '1';

    protected static array $scopes = [
        'channel:read:goals', // TODO change to Scope::CHANNEL_READ_GOALS
    ];

    public string $id;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public string $goalType;

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
        $this->goalType = $event['type'];
        $this->description = $event['description'];
        $this->achieved = $event['is_achieved'];
        $this->currentAmount = $event['current_amount'];
        $this->targetAmount = $event['target_amount'];
        $this->startedAt = $this->parseCarbon($event['started_at']);
    }

    public function isFollower(): bool
    {
        return $this->goalType === 'follower';
    }

    public function isSubscription(): bool
    {
        return $this->goalType === 'subscription';
    }

    public function isNewSubscription(): bool
    {
        return $this->goalType === 'new_subscription';
    }

    public static function subscribe(string $broadcasterId, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo(self::getVersion(), [
            'broadcaster_user_id' => $broadcasterId,
        ], false, $callbackUrl);
    }
}
