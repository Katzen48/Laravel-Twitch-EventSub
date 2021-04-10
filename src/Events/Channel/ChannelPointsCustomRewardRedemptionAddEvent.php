<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use katzen48\Twitch\EventSub\Events\BaseEvent;
use katzen48\Twitch\EventSub\Objects\ChannelPointsCustomRewardPart;

class ChannelPointsCustomRewardRedemptionAddEvent extends BaseEvent
{
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
        $this->redeemerId = $event['id'];
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
}