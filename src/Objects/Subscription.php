<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:48 PM
 */

namespace katzen48\Twitch\EventSub\Objects;

use Carbon\CarbonInterface;
use katzen48\Twitch\EventSub\Enums\SubscriptionStatus;
use katzen48\Twitch\EventSub\Facades\TwitchEventSub;

class Subscription
{
    public string $id;

    public string $status;

    public string $type;

    public string $version;

    public int $cost;

    public array $condition;

    public Transport $transport;

    public CarbonInterface $created_at;

    public function unsubscribe(): bool
    {
        if (! $this->isActive()) {
            return false;
        }

        return TwitchEventSub::unsubscribeEvent($this->id);
    }

    public function isActive(): bool
    {
        return $this->status === SubscriptionStatus::ENABLED;
    }
}
