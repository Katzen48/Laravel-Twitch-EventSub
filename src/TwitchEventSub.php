<?php

namespace katzen48\Twitch\EventSub;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use romanzipp\Twitch\Twitch;

/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:05 PM
 */
class TwitchEventSub
{
    private Twitch $twitch;

    public function __construct()
    {
        $this->twitch = App::make(Twitch::class);
    }

    /**
     * @param string $type
     * @param string $version
     * @param array $condition
     * @param bool $batching
     * @param string|null $callbackUrl
     * @return string|null ID of the subscription
     */
    public function subscribeEvent(string $type, string $version, array $condition, bool $batching = false, string $callbackUrl = null): ?string
    {
        $sub = [
            'type' => $type,
            'version' => $version,
            'condition' => $condition,
            'transport' => [
                'method' => 'webhook',
                'callback' => rtrim(config('app.url'), '/') . ($callbackUrl ?: config('twitch-eventsub.callback_url')),
            ],
        ];

        if($this->doesEventAllowBatching($type)) {
            $sub['is_batching_enabled'] = $batching;
        }

        if($this->doesEventRequireBatching($type)) {
            $sub['is_batching_enabled'] = true;
        }

        $result = $this->twitch->subscribeEventSub([], $sub);

        if ($result->success()) {
            return $result->data()[0]->id;
        }

        Log::error($result->getErrorMessage());
        return null;
    }

    public function unsubscribeEvent(string $subscriptionId): bool
    {
        $result = $this->twitch->unsubscribeEventSub(['id' => $subscriptionId]);

        if ($result->success()) {
            return true;
        }

        Log::error($result->getErrorMessage());
        return false;
    }

    public function doesEventAllowBatching(string $type): bool
    {
        return match($type) {
            default => false,
        };
    }

    public function doesEventRequireBatching(string $type): bool
    {
        return match($type) {
            'drop.entitlement.grant' => true,
            default => false,
        };
    }
}