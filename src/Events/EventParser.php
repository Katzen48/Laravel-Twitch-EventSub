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
            return match ($payload['subscription']['status']) {
                SubscriptionStatus::VERIFICATION_PENDING => \katzen48\Twitch\EventSub\Events\EventSub\CallbackVerificationEvent::class,
                default => throw new \DomainException('Unsupported subscription status'),
            };
        }

        return self::getEventClassMapping()[
                $payload['subscription']['type']
            ] ?? throw new \DomainException('Unsupported subscription type');
    }

    public static function getEventClassMapping(): array
    {
        return [
            EventSubType::USER_AUTHORIZATION_REVOKE =>
                \katzen48\Twitch\EventSub\Events\User\UserAuthorizationRevokeEvent::class,
            EventSubType::USER_UPDATE =>
                \katzen48\Twitch\EventSub\Events\User\UserUpdateEvent::class,

            EventSubType::STREAM_ONLINE =>
                \katzen48\Twitch\EventSub\Events\Stream\StreamOnlineEvent::class,
            EventSubType::STREAM_OFFLINE =>
                \katzen48\Twitch\EventSub\Events\Stream\StreamOfflineEvent::class,

            EventSubType::CHANNEL_FOLLOW =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelFollowEvent::class,
            EventSubType::CHANNEL_UPDATE =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelUpdateEvent::class,
            EventSubType::CHANNEL_SUBSCRIBE =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelSubscribeEvent::class,
            EventSubType::CHANNEL_UNSUBSCRIBE => // TODO change to EventSubType::CHANNEL_SUBSCRIPTION_END
                \katzen48\Twitch\EventSub\Events\Channel\ChannelUnsubscribeEvent::class,
            'channel.subscription.gift' => // TODO change to EventSubType::CHANNEL_SUBSCRIPTION_GIFT
                \katzen48\Twitch\EventSub\Events\Channel\ChannelSubscriptionGiftEvent::class,
            'channel.subscription.message' => // TODO change to EventSubType::CHANNEL_SUBSCRIPTION_MESSAGE
                \katzen48\Twitch\EventSub\Events\Channel\ChannelSubscriptionMessageEvent::class,
            EventSubType::CHANNEL_CHEER =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelCheerEvent::class,
            EventSubType::CHANNEL_RAID =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelRaidEvent::class,
            EventSubType::CHANNEL_BAN =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelBanEvent::class,
            EventSubType::CHANNEL_UNBAN =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelUnbanEvent::class,
            EventSubType::CHANNEL_MODERATOR_ADD =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelModeratorAddEvent::class,
            EventSubType::CHANNEL_MODERATOR_REMOVE =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelModeratorRemoveEvent::class,
            EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARDS_ADD =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelPointsCustomRewardAddEvent::class,
            EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARDS_UPDATE =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelPointsCustomRewardUpdateEvent::class,
            EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARDS_REMOVE =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelPointsCustomRewardRemoveEvent::class,
            EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARD_REDEMPTION_ADD =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelPointsCustomRewardRedemptionAddEvent::class,
            EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARD_REDEMPTION_UPDATE =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelPointsCustomRewardRedemptionUpdateEvent::class,
            EventSubType::CHANNEL_HYPE_TRAIN_BEGIN =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelHypeTrainBeginEvent::class,
            EventSubType::CHANNEL_HYPE_TRAIN_PROGRESS =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelHypeTrainProgressEvent::class,
            EventSubType::CHANNEL_HYPE_TRAIN_END =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelHypeTrainEndEvent::class,
            'extension.bits_transaction.create' => // TODO change to EventSubType::EXTENSION_BITS_TRANSACTION_CREATE
                \katzen48\Twitch\EventSub\Events\Extension\ExtensionBitsTransactionCreateEvent::class,
        ];
    }
}