<?php
/**
 * User: Katzen48
 * Date: 6/19/2021
 * Time: 8:32 PM
 */

namespace katzen48\Twitch\EventSub\Objects;

use Illuminate\Support\Collection;

class ChannelPredictionOutcomeProgressed extends ChannelPredictionOutcome
{
    public int $users;

    public int $channelPoints;

    /**
     * @var Collection|ChannelPredictionPredictor contains up to 10 users
     */
    public $topPredictors;
}
