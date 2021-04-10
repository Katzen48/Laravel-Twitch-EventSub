<?php

namespace katzen48\Twitch\EventSub\Events;

use katzen48\Twitch\EventSub\Enums\SubscriptionStatus;
use romanzipp\Twitch\Enums\EventSubType;

/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:15 PM
 */
class EventParser
{
    public static function parse($payload): string
    {
        if ($payload['subscription']['status'] !== SubscriptionStatus::ENABLED) {
            switch ($payload['subscription']['status']) {
                case SubscriptionStatus::VERIFICATION_PENDING:
                    return \katzen48\Twitch\EventSub\Events\EventSub\CallbackVerificationEvent::class;
                default:
                    throw new \DomainException('Unsupported subscription status');
            }
        }

        switch ($payload['subscription']['type']) {
            case EventSubType::CHANNEL_UPDATE:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelUpdateEvent::class;
            case EventSubType::CHANNEL_SUBSCRIBE:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelSubscribeEvent::class;
            case EventSubType::CHANNEL_FOLLOW:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelFollowEvent::class;
            case EventSubType::CHANNEL_RAID:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelRaidEvent::class;
            case EventSubType::CHANNEL_BAN:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelBanEvent::class;
            case EventSubType::CHANNEL_UNBAN:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelUnbanEvent::class;
            case 'channel.moderator.add': // TODO change, when the eventsub type is added to laravel-twitch
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelModeratorAddEvent::class;
            case 'channel.moderator.remove': // TODO change, when the eventsub type is added to laravel-twitch
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelModeratorRemoveEvent::class;
            case EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARDS_ADD:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelPointsCustomRewardAddEvent::class;
            case EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARDS_UPDATE:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelPointsCustomRewardUpdateEvent::class;
            case EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARDS_REMOVE:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelPointsCustomRewardRemoveEvent::class;
            case EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARD_REDEMPTION_ADD:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelPointsCustomRewardRedemptionAddEvent::class;
            case EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARD_REDEMPTION_UPDATE:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelPointsCustomRewardRedemptionUpdateEvent::class;
            case EventSubType::CHANNEL_HYPE_TRAIN_BEGIN:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelHypeTrainBeginEvent::class;
            case EventSubType::CHANNEL_HYPE_TRAIN_PROGRESS:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelHypeTrainProgressEvent::class;
            case EventSubType::CHANNEL_HYPE_TRAIN_END:
                return \katzen48\Twitch\EventSub\Events\Channel\ChannelHypeTrainEndEvent::class;
            case EventSubType::STREAM_ONLINE:
                return \katzen48\Twitch\EventSub\Events\Stream\StreamOnlineEvent::class;
            case EventSubType::STREAM_OFFLINE:
                return \katzen48\Twitch\EventSub\Events\Stream\StreamOfflineEvent::class;
            case EventSubType::USER_AUTHORIZATION_REVOKE:
                return \katzen48\Twitch\EventSub\Events\User\UserAuthorizationRevokeEvent::class;
            case EventSubType::USER_UPDATE:
                return \katzen48\Twitch\EventSub\Events\User\UserUpdateEvent::class;
            default:
                throw new \DomainException('Unsupported subscription type');
        }

    }
}