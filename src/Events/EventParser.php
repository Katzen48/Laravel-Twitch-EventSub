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
            Stream\StreamOfflineEvent::type => Stream\StreamOfflineEvent::class,
            Stream\StreamOnlineEvent::type => Stream\StreamOnlineEvent::class,

            // Channel
            Channel\ChannelBanEvent::type => Channel\ChannelBanEvent::class,
            Channel\ChannelCheerEvent::type => Channel\ChannelCheerEvent::class,
            Channel\ChannelFollowEvent::type => Channel\ChannelFollowEvent::class,
            Channel\ChannelModeratorAddEvent::type => Channel\ChannelModeratorAddEvent::class,
            Channel\ChannelModeratorRemoveEvent::type => Channel\ChannelModeratorRemoveEvent::class,
            Channel\ChannelRaidEvent::type => Channel\ChannelRaidEvent::class,
            Channel\ChannelUnbanEvent::type => Channel\ChannelUnbanEvent::class,
            Channel\ChannelUpdateEvent::type => Channel\ChannelUpdateEvent::class,

            // Channel Points
            Channel\ChannelPoints\ChannelPointsCustomRewardAddEvent::type => Channel\ChannelPoints\ChannelPointsCustomRewardAddEvent::class,
            Channel\ChannelPoints\ChannelPointsCustomRewardRedemptionAddEvent::type => Channel\ChannelPoints\ChannelPointsCustomRewardRedemptionAddEvent::class,
            Channel\ChannelPoints\ChannelPointsCustomRewardRedemptionUpdateEvent::type => Channel\ChannelPoints\ChannelPointsCustomRewardRedemptionUpdateEvent::class,
            Channel\ChannelPoints\ChannelPointsCustomRewardRemoveEvent::type => Channel\ChannelPoints\ChannelPointsCustomRewardRemoveEvent::class,
            Channel\ChannelPoints\ChannelPointsCustomRewardUpdateEvent::type => Channel\ChannelPoints\ChannelPointsCustomRewardUpdateEvent::class,

            // Goal
            Channel\Goal\ChannelGoalBeginEvent::type => Channel\Goal\ChannelGoalBeginEvent::class,
            Channel\Goal\ChannelGoalEndEvent::type => Channel\Goal\ChannelGoalEndEvent::class,
            Channel\Goal\ChannelGoalProgressEvent::type => Channel\Goal\ChannelGoalProgressEvent::class,

            // Hype Train
            Channel\HypeTrain\ChannelHypeTrainBeginEvent::type => Channel\HypeTrain\ChannelHypeTrainBeginEvent::class,
            Channel\HypeTrain\ChannelHypeTrainEndEvent::type => Channel\HypeTrain\ChannelHypeTrainEndEvent::class,
            Channel\HypeTrain\ChannelHypeTrainProgressEvent::type => Channel\HypeTrain\ChannelHypeTrainProgressEvent::class,

            // Poll
            Channel\Poll\ChannelPollBeginEvent::type => Channel\Poll\ChannelPollBeginEvent::class,
            Channel\Poll\ChannelPollEndEvent::type => Channel\Poll\ChannelPollEndEvent::class,
            Channel\Poll\ChannelPollProgressEvent::type => Channel\Poll\ChannelPollProgressEvent::class,

            // Prediction
            Channel\Prediction\ChannelPredictionBeginEvent::type => Channel\Prediction\ChannelPredictionBeginEvent::class,
            Channel\Prediction\ChannelPredictionEndEvent::type => Channel\Prediction\ChannelPredictionEndEvent::class,
            Channel\Prediction\ChannelPredictionLockEvent::type => Channel\Prediction\ChannelPredictionLockEvent::class,
            Channel\Prediction\ChannelPredictionProgressEvent::type => Channel\Prediction\ChannelPredictionProgressEvent::class,

            // Subscription
            Channel\Subscription\ChannelSubscribeEvent::type => Channel\Subscription\ChannelSubscribeEvent::class,
            Channel\Subscription\ChannelSubscriptionEndEvent::type => Channel\Subscription\ChannelSubscriptionEndEvent::class,
            Channel\Subscription\ChannelSubscriptionGiftEvent::type => Channel\Subscription\ChannelSubscriptionGiftEvent::class,
            Channel\Subscription\ChannelSubscriptionMessageEvent::type => Channel\Subscription\ChannelSubscriptionMessageEvent::class,

            // Drop
            Drop\DropEntitlementGrantEvent::type => Drop\DropEntitlementGrantEvent::class,

            // Extension
            Extension\ExtensionBitsTransactionCreateEvent::type => Extension\ExtensionBitsTransactionCreateEvent::class,

            // User
            User\UserAuthorizationGrantEvent::type => User\UserAuthorizationGrantEvent::class,
            User\UserAuthorizationRevokeEvent::type => User\UserAuthorizationRevokeEvent::class,
            User\UserUpdateEvent::type => User\UserUpdateEvent::class,
        ];
    }
}
