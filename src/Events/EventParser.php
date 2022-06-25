<?php

namespace katzen48\Twitch\EventSub\Events;

use katzen48\Twitch\EventSub\Enums\SubscriptionStatus;

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
                SubscriptionStatus::VERIFICATION_PENDING => EventSub\CallbackVerificationEvent::class,
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
            // Stream
            Stream\StreamOfflineEvent::getType() => Stream\StreamOfflineEvent::class,
            Stream\StreamOnlineEvent::getType() => Stream\StreamOnlineEvent::class,

            // Channel
            Channel\ChannelBanEvent::getType() => Channel\ChannelBanEvent::class,
            Channel\ChannelCheerEvent::getType() => Channel\ChannelCheerEvent::class,
            Channel\ChannelFollowEvent::getType() => Channel\ChannelFollowEvent::class,
            Channel\ChannelModeratorAddEvent::getType() => Channel\ChannelModeratorAddEvent::class,
            Channel\ChannelModeratorRemoveEvent::getType() => Channel\ChannelModeratorRemoveEvent::class,
            Channel\ChannelRaidEvent::getType() => Channel\ChannelRaidEvent::class,
            Channel\ChannelUnbanEvent::getType() => Channel\ChannelUnbanEvent::class,
            Channel\ChannelUpdateEvent::getType() => Channel\ChannelUpdateEvent::class,

            // Channel Points
            Channel\ChannelPoints\ChannelPointsCustomRewardAddEvent::getType() => Channel\ChannelPoints\ChannelPointsCustomRewardAddEvent::class,
            Channel\ChannelPoints\ChannelPointsCustomRewardRedemptionAddEvent::getType() => Channel\ChannelPoints\ChannelPointsCustomRewardRedemptionAddEvent::class,
            Channel\ChannelPoints\ChannelPointsCustomRewardRedemptionUpdateEvent::getType() => Channel\ChannelPoints\ChannelPointsCustomRewardRedemptionUpdateEvent::class,
            Channel\ChannelPoints\ChannelPointsCustomRewardRemoveEvent::getType() => Channel\ChannelPoints\ChannelPointsCustomRewardRemoveEvent::class,
            Channel\ChannelPoints\ChannelPointsCustomRewardUpdateEvent::getType() => Channel\ChannelPoints\ChannelPointsCustomRewardUpdateEvent::class,

            // Goal
            Channel\Goal\ChannelGoalBeginEvent::getType() => Channel\Goal\ChannelGoalBeginEvent::class,
            Channel\Goal\ChannelGoalEndEvent::getType() => Channel\Goal\ChannelGoalEndEvent::class,
            Channel\Goal\ChannelGoalProgressEvent::getType() => Channel\Goal\ChannelGoalProgressEvent::class,

            // Hype Train
            Channel\HypeTrain\ChannelHypeTrainBeginEvent::getType() => Channel\HypeTrain\ChannelHypeTrainBeginEvent::class,
            Channel\HypeTrain\ChannelHypeTrainEndEvent::getType() => Channel\HypeTrain\ChannelHypeTrainEndEvent::class,
            Channel\HypeTrain\ChannelHypeTrainProgressEvent::getType() => Channel\HypeTrain\ChannelHypeTrainProgressEvent::class,

            // Poll
            Channel\Poll\ChannelPollBeginEvent::getType() => Channel\Poll\ChannelPollBeginEvent::class,
            Channel\Poll\ChannelPollEndEvent::getType() => Channel\Poll\ChannelPollEndEvent::class,
            Channel\Poll\ChannelPollProgressEvent::getType() => Channel\Poll\ChannelPollProgressEvent::class,

            // Prediction
            Channel\Prediction\ChannelPredictionBeginEvent::getType() => Channel\Prediction\ChannelPredictionBeginEvent::class,
            Channel\Prediction\ChannelPredictionEndEvent::getType() => Channel\Prediction\ChannelPredictionEndEvent::class,
            Channel\Prediction\ChannelPredictionLockEvent::getType() => Channel\Prediction\ChannelPredictionLockEvent::class,
            Channel\Prediction\ChannelPredictionProgressEvent::getType() => Channel\Prediction\ChannelPredictionProgressEvent::class,

            // Subscription
            Channel\Subscription\ChannelSubscribeEvent::getType() => Channel\Subscription\ChannelSubscribeEvent::class,
            Channel\Subscription\ChannelSubscriptionEndEvent::getType() => Channel\Subscription\ChannelSubscriptionEndEvent::class,
            Channel\Subscription\ChannelSubscriptionGiftEvent::getType() => Channel\Subscription\ChannelSubscriptionGiftEvent::class,
            Channel\Subscription\ChannelSubscriptionMessageEvent::getType() => Channel\Subscription\ChannelSubscriptionMessageEvent::class,

            // Drop
            Drop\DropEntitlementGrantEvent::getType() => Drop\DropEntitlementGrantEvent::class,

            // Extension
            Extension\ExtensionBitsTransactionCreateEvent::getType() => Extension\ExtensionBitsTransactionCreateEvent::class,

            // User
            User\UserAuthorizationGrantEvent::getType() => User\UserAuthorizationGrantEvent::class,
            User\UserAuthorizationRevokeEvent::getType() => User\UserAuthorizationRevokeEvent::class,
            User\UserUpdateEvent::getType() => User\UserUpdateEvent::class,
        ];
    }
}
