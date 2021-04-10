<?php
/**
 * User: Katzen48
 * Date: 4/10/2021
 * Time: 2:04 AM
 */

namespace katzen48\Twitch\EventSub\Events;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use katzen48\Twitch\EventSub\TwitchEventSub;

class ModelEventSubscriber
{
    public static function onCreate($model)
    {
        foreach ($model::$eventSubs as $type => $conditionParameters) {
            /**
             * @var TwitchEventSub $eventSub
             */
            $eventSub = App::make(TwitchEventSub::class);

            $condition = collect($conditionParameters)->map(function ($item, $key) use ($model) {
                return $model->{$item};
            });

            Log::info($condition);

            $eventSub->subscribeEvent($type, '1', $condition->all());
        }
    }
}