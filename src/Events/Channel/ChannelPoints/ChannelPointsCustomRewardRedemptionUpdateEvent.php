<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel\ChannelPoints;

use Carbon\CarbonInterface;
use katzen48\Twitch\EventSub\Events\BaseEvent;
use katzen48\Twitch\EventSub\Objects\ChannelPointsCustomRewardPart;
use romanzipp\Twitch\Enums\EventSubType;
use romanzipp\Twitch\Enums\Scope;

class ChannelPointsCustomRewardRedemptionUpdateEvent extends BaseEvent
{
    protected static string $type = EventSubType::CHANNEL_CHANNEL_POINTS_CUSTOM_REWARD_REDEMPTION_UPDATE;

    protected static string $version = '1';

    protected static array $scopes = [
        Scope::CHANNEL_READ_REDEMPTIONS, Scope::CHANNEL_MANAGE_REDEMPTIONS,
    ];

    public string $redemptionId;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public string $redeemerId;

    public string $redeemerLogin;

    public string $redeemerName;

    public string $input;

    public string $status;

    public ChannelPointsCustomRewardPart $reward;

    public CarbonInterface $redeemedAt;

    public function parseEvent($event): void
    {
        $this->redemptionId = $event['id'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->redeemerId = $event['user_id'];
        $this->redeemerLogin = $event['user_login'];
        $this->redeemerName = $event['user_name'];
        $this->input = $event['user_input'];
        $this->status = $event['status'];

        $this->reward = new ChannelPointsCustomRewardPart;
        $this->reward->id = $event['reward']['id'];
        $this->reward->title = $event['reward']['title'];
        $this->reward->cost = $event['reward']['cost'];
        $this->reward->prompt = $event['reward']['prompt'];

        $this->redeemedAt = $this->parseCarbon($event['redeemed_at']);
    }

    public static function subscribe(string $broadcasterId, string $rewardId = null, string $callbackUrl = null): ?string
    {
        $condition = [
            'broadcaster_user_id' => $broadcasterId,
        ];

        if ($rewardId) {
            $condition['reward_id'] = $rewardId;
        }

        return parent::subscribeTo(self::getVersion(),
            $condition, false, $callbackUrl);
    }
}
