<?php
/**
 * User: Katzen48
 * Date: 4/10/2021
 * Time: 2:02 AM
 */

namespace katzen48\Twitch\EventSub\Traits;

use katzen48\Twitch\EventSub\Events\ModelEventSubscriber;

/**
 * Trait SubscribesEventSubs
 *
 * @property $eventSubs array
 */
trait SubscribesEventSubs
{
    public static function bootSubscribesEventSubs(): void
    {
        if (! property_exists(static::class, 'eventSubs')) {
            return;
        }

        static::created(static function ($model) {
            ModelEventSubscriber::onCreate($model);
        });
    }
}
