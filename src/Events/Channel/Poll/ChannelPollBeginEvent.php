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
use katzen48\Twitch\EventSub\Objects\ChannelPollChoice;
use katzen48\Twitch\EventSub\Objects\ChannelPollCurrencyVoting;
use romanzipp\Twitch\Enums\EventSubType;
use romanzipp\Twitch\Enums\Scope;

class ChannelPollBeginEvent extends BaseEvent
{
    protected static string $type = EventSubType::CHANNEL_POLL_BEGIN;
    protected static string $version = '1';

    protected static array $scopes = [
        Scope::CHANNEL_READ_POLLS, Scope::CHANNEL_MANAGE_POLLS,
    ];

    public string $id;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public string $title;

    /**
     * @var Collection|ChannelPollChoice
     */
    public $choices;

    public ChannelPollCurrencyVoting $bitsVoting;

    public ChannelPollCurrencyVoting $channelPointsVoting;

    public CarbonInterface $startedAt;

    public CarbonInterface $endsAt;

    public function parseEvent($event): void
    {
        $this->id = $event['id'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->title = $event['title'];

        $this->choices = collect();
        foreach ($event['choices'] as $item) {
            $choice = new ChannelPollChoice();
            $choice->id = $item['id'];
            $choice->title = $item['title'];

            $this->choices->add($choice);
        }

        $this->bitsVoting = new ChannelPollCurrencyVoting();
        $this->bitsVoting->enabled = $event['bits_voting']['is_enabled'];
        $this->bitsVoting->amountPerVote = $event['bits_voting']['amount_per_vote'];

        $this->channelPointsVoting = new ChannelPollCurrencyVoting();
        $this->channelPointsVoting->enabled = $event['channel_points_voting']['is_enabled'];
        $this->channelPointsVoting->amountPerVote = $event['channel_points_voting']['amount_per_vote'];

        $this->startedAt = $this->parseCarbon($event['started_at']);
        $this->endsAt = $this->parseCarbon($event['ends_at']);
    }

    public static function subscribe(string $broadcasterId, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo(self::getVersion(), [
            'broadcaster_user_id' => $broadcasterId,
        ], false, $callbackUrl);
    }
}
