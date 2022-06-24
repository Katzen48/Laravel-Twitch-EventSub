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

class ChannelPredictionBeginEvent extends BaseEvent
{
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
}
