<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel\ChannelPoints;

use Carbon\CarbonInterface;
use katzen48\Twitch\EventSub\Events\BaseEvent;
use katzen48\Twitch\EventSub\Objects\ChannelPointsRedemptionCooldown;
use katzen48\Twitch\EventSub\Objects\ChannelPointsRedemptionLimit;
use katzen48\Twitch\EventSub\Objects\TwitchCdnImage;

class ChannelPointsCustomRewardAddEvent extends BaseEvent
{
    public string $rewardId;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public bool $enabled;

    public bool $paused;

    public bool $inStock;

    public string $title;

    public int $cost;

    public string $prompt;

    public bool $userInputRequired;

    public bool $redemptionsSkipRequestQueue;

    public CarbonInterface $cooldownExpiresAt;

    public int $redemptionsRedeemedCurrentStream;

    public ChannelPointsRedemptionLimit $maxPerStream;

    public ChannelPointsRedemptionLimit $maxPerUserPerStream;

    public ChannelPointsRedemptionCooldown $globalCooldown;

    public string $backgroundColor;

    public TwitchCdnImage $image;

    public TwitchCdnImage $defaultImage;

    public function parseEvent($event): void
    {
        $this->rewardId = $event['id'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->enabled = $event['is_enabled'];
        $this->paused = $event['is_paused'];
        $this->inStock = $event['is_in_stock'];
        $this->title = $event['title'];
        $this->cost = $event['cost'];
        $this->prompt = $event['prompt'];
        $this->userInputRequired = $event['is_user_input_required'];
        $this->redemptionsSkipRequestQueue = $event['should_redemptions_skip_request_queue'];
        $this->cooldownExpiresAt = $this->parseCarbon($event['cooldown_expires_at']) ?? null;
        $this->redemptionsRedeemedCurrentStream = $event['redemptions_redeemed_current_stream'];

        $this->maxPerStream = new ChannelPointsRedemptionLimit;
        $this->maxPerStream->enabled = $event['max_per_stream']['enabled'];
        $this->maxPerStream->value = $event['max_per_stream']['value'];

        $this->maxPerUserPerStream = new ChannelPointsRedemptionLimit;
        $this->maxPerUserPerStream->enabled = $event['max_per_user_per_stream']['enabled'];
        $this->maxPerUserPerStream->value = $event['max_per_user_per_stream']['value'];

        $this->globalCooldown = new ChannelPointsRedemptionCooldown;
        $this->globalCooldown->enabled = $event['global_cooldown']['enabled'];
        $this->globalCooldown->seconds = $event['global_cooldown']['seconds'];

        $this->backgroundColor = $event['background_color'];

        $this->image = new TwitchCdnImage;
        $this->image->url1x = $event['image']['url_1x'];
        $this->image->url2x = $event['image']['url_2x'];
        $this->image->url4x = $event['image']['url_4x'];

        $this->defaultImage = new TwitchCdnImage;
        $this->defaultImage->url1x = $event['default_image']['url_1x'];
        $this->defaultImage->url2x = $event['default_image']['url_2x'];
        $this->defaultImage->url4x = $event['default_image']['url_4x'];
    }
}