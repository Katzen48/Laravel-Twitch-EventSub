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
     * @param string|null $callbackUrl
     * @return string ID of the subscription
     */
    public function subscribeEvent(string $type, string $version, array $condition, string $callbackUrl = null): ?string
    {
        $result = $this->twitch->subscribeEventSub([], [
            'type' => $type,
            'version' => $version,
            'condition' => $condition,
            'transport' => [
                'method' => 'webhook',
                'callback' => rtrim(config('app.url'), '/') . ($callbackUrl ?: config('twitch-eventsub.callback_url')),
            ],
        ]);

        if ($result->success()) {
            return $result->data()[0]->id;
        } else {
            Log::error($result->getErrorMessage());
            return null;
        }
    }

    public function unsubscribeEvent(string $subscriptionId): bool
    {
        $result = $this->twitch->unsubscribeEventSub(['id' => $subscriptionId]);

        if ($result->success()) {
            return true;
        } else {
            Log::error($result->getErrorMessage());
            return false;
        }
    }
}