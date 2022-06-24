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
            EventSubType::STREAM_ONLINE =>
                \katzen48\Twitch\EventSub\Events\Stream\StreamOnlineEvent::class,
            EventSubType::STREAM_OFFLINE =>
                \katzen48\Twitch\EventSub\Events\Stream\StreamOfflineEvent::class,

            EventSubType::CHANNEL_FOLLOW =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelFollowEvent::class,
            EventSubType::CHANNEL_UPDATE =>
                \katzen48\Twitch\EventSub\Events\Channel\ChannelUpdateEvent::class,
            EventSubType::CHANNEL_SUBSCRIBE =>
                Channel\Subscription\ChannelSubscribeEvent::class,
            EventSubType::CHANNEL_SUBSCRIPTION_END =>
                Channel\Subscription\ChannelSubscriptionEndEvent::class,
            EventSubType::CHANNEL_SUBSCRIPTION_GIFT =>
                Channel\Subscription\ChannelSubscriptionGiftEvent::class,
            EventSubType::CHANNEL_SUBSCRIPTION_MESSAGE =>
                Channel\Subscription\ChannelSubscriptionMessageEvent::class,
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
                Channel\ChannelPoints\ChannelPointsCustomRewardAddEvent::class,
            EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARDS_UPDATE =>
                Channel\ChannelPoints\ChannelPointsCustomRewardUpdateEvent::class,
            EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARDS_REMOVE =>
                Channel\ChannelPoints\ChannelPointsCustomRewardRemoveEvent::class,
            EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARD_REDEMPTION_ADD =>
                Channel\ChannelPoints\ChannelPointsCustomRewardRedemptionAddEvent::class,
            EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARD_REDEMPTION_UPDATE =>
                Channel\ChannelPoints\ChannelPointsCustomRewardRedemptionUpdateEvent::class,
            EventSubType::CHANNEL_POLL_BEGIN =>
                Channel\Poll\ChannelPollBeginEvent::class,
            EventSubType::CHANNEL_POLL_PROGRESS =>
                Channel\Poll\ChannelPollProgressEvent::class,
            EventSubType::CHANNEL_POLL_END =>
                Channel\Poll\ChannelPollEndEvent::class,
            EventSubType::CHANNEL_PREDICTION_BEGIN =>
                Channel\Prediction\ChannelPredictionBeginEvent::class,
            EventSubType::CHANNEL_PREDICTION_PROGRESS =>
                Channel\Prediction\ChannelPredictionProgressEvent::class,
            EventSubType::CHANNEL_PREDICTION_LOCK =>
                Channel\Prediction\ChannelPredictionLockEvent::class,
            EventSubType::CHANNEL_PREDICTION_END =>
                Channel\Prediction\ChannelPredictionEndEvent::class,
            EventSubType::CHANNEL_HYPE_TRAIN_BEGIN =>
                Channel\HypeTrain\ChannelHypeTrainBeginEvent::class,
            EventSubType::CHANNEL_HYPE_TRAIN_PROGRESS =>
                Channel\HypeTrain\ChannelHypeTrainProgressEvent::class,
            EventSubType::CHANNEL_HYPE_TRAIN_END =>
                Channel\HypeTrain\ChannelHypeTrainEndEvent::class,
            'channel.goal.begin' => // TODO change to EventSubType::CHANNEL_GOAL_BEGIN
            Channel\Goal\ChannelGoalBeginEvent::class,
            'channel.goal.progress' => // TODO change to EventSubType::CHANNEL_GOAL_PROGRESS
                Channel\Goal\ChannelGoalProgressEvent::class,
            'channel.goal.end' => // TODO change to EventSubType::CHANNEL_GOAL_END
                Channel\Goal\ChannelGoalEndEvent::class,

            EventSubType::EXTENSION_BITS_TRANSACTION_CREATE =>
                \katzen48\Twitch\EventSub\Events\Extension\ExtensionBitsTransactionCreateEvent::class,

            EventSubType::DROP_ENTITLEMENT_GRANT =>
                \katzen48\Twitch\EventSub\Events\Drop\DropEntitlementGrantEvent::class,

            EventSubType::USER_AUTHORIZATION_GRANT =>
                \katzen48\Twitch\EventSub\Events\User\UserAuthorizationGrantEvent::class,
            EventSubType::USER_AUTHORIZATION_REVOKE =>
                \katzen48\Twitch\EventSub\Events\User\UserAuthorizationRevokeEvent::class,
            EventSubType::USER_UPDATE =>
                \katzen48\Twitch\EventSub\Events\User\UserUpdateEvent::class,
        ];
    }
}