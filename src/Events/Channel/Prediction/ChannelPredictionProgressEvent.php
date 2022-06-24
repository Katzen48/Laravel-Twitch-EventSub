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
use katzen48\Twitch\EventSub\Objects\ChannelPredictionOutcomeProgressed;
use katzen48\Twitch\EventSub\Objects\ChannelPredictionPredictor;

class ChannelPredictionProgressEvent extends BaseEvent
{
    public string $id;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public string $title;

    /**
     * @var Collection|ChannelPredictionOutcomeProgressed
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
            $outcome = new ChannelPredictionOutcomeProgressed();
            $outcome->id = $item['id'];
            $outcome->title = $item['title'];
            $outcome->color = $item['color'];
            $outcome->users = $item['users'];
            $outcome->channelPoints = $item['channel_points'];
            $outcome->topPredictors = collect();

            foreach ($item['top_predictors'] as $pred) {
                $predictor = new ChannelPredictionPredictor();
                $predictor->userName = $pred['user_name'];
                $predictor->userLogin = $pred['user_login'];
                $predictor->userId = $pred['user_id'];
                $predictor->channelPointsWon = $pred['channel_points_won'];
                $predictor->channelPointsUsed = $pred['channel_points_used'];

                $outcome->topPredictors->add($predictor);
            }

            $this->outcomes->add($outcome);
        }
        $this->startedAt = $this->parseCarbon($event['started_at']);
        $this->locksAt = $this->parseCarbon($event['locks_at']);
    }
}
