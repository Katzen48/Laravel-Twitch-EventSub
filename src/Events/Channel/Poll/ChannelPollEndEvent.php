<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:59 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel\Poll;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use katzen48\Twitch\EventSub\Events\BaseEvent;
use katzen48\Twitch\EventSub\Objects\ChannelPollChoiceProgressed;
use katzen48\Twitch\EventSub\Objects\ChannelPollCurrencyVoting;

class ChannelPollEndEvent extends BaseEvent
{
    public string $id;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public string $title;

    /**
     * @var Collection|ChannelPollChoiceProgressed
     */
    public $choices;

    public ChannelPollCurrencyVoting $bitsVoting;

    public ChannelPollCurrencyVoting $channelPointsVoting;

    public string $status;

    public CarbonInterface $startedAt;

    public CarbonInterface $endedAt;

    public function parseEvent($event): void
    {
        $this->id = $event['id'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->title = $event['title'];

        $this->choices = collect();
        foreach ($event['choices'] as $item) {
            $choice = new ChannelPollChoiceProgressed();
            $choice->id = $item['id'];
            $choice->title = $item['title'];
            $choice->bitsVotes = $item['bits_votes'];
            $choice->channelPointsVotes = $item['channel_points_votes'];
            $choice->votes = $item['votes'];

            $this->choices->add($choice);
        }

        $this->bitsVoting = new ChannelPollCurrencyVoting();
        $this->bitsVoting->enabled = $event['bits_voting']['is_enabled'];
        $this->bitsVoting->amountPerVote = $event['bits_voting']['amount_per_vote'];

        $this->channelPointsVoting = new ChannelPollCurrencyVoting();
        $this->channelPointsVoting->enabled = $event['channel_points_voting']['is_enabled'];
        $this->channelPointsVoting->amountPerVote = $event['channel_points_voting']['amount_per_vote'];

        $this->status = $event['status'];
        $this->startedAt = $this->parseCarbon($event['started_at']);
        $this->endedAt = $this->parseCarbon($event['ended_at']);
    }
}