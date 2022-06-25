<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:59 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel\Prediction;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use katzen48\Twitch\EventSub\Events\BaseEvent;
use katzen48\Twitch\EventSub\Objects\ChannelPredictionOutcome;
use romanzipp\Twitch\Enums\EventSubType;
use romanzipp\Twitch\Enums\Scope;

class ChannelPredictionBeginEvent extends BaseEvent
{
    protected static string $type = EventSubType::CHANNEL_PREDICTION_BEGIN;

    protected static array $scopes = [
        Scope::CHANNEL_READ_PREDICTIONS, Scope::CHANNEL_MANAGE_PREDICTIONS,
    ];

    public string $id;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public string $title;

    /**
     * @var Collection|ChannelPredictionOutcome
     */
    public $outcomes;

    public CarbonInterface $startedAt;

    public CarbonInterface $locksAt;

    public function parseEvent($event): void
    {
        $this->id = $event['id'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->title = $event['title'];

        $this->outcomes = collect();
        foreach ($event['outcomes'] as $item) {
            $outcome = new ChannelPredictionOutcome();
            $outcome->id = $item['id'];
            $outcome->title = $item['title'];
            $outcome->color = $item['color'];

            $this->outcomes->add($outcome);
        }

        $this->startedAt = $this->parseCarbon($event['started_at']);
        $this->locksAt = $this->parseCarbon($event['locks_at']);
    }

    public static function subscribe(string $broadcasterId, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo('1', [
            'broadcaster_user_id' => $broadcasterId,
        ], false, $callbackUrl);
    }
}
