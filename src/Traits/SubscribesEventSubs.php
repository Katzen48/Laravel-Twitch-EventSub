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
 * @package katzen48\Twitch\EventSub\Traits
 *
 * @property array $eventSubs
 */
trait SubscribesEventSubs
{
    public static function bootSubscribesEventSubs(): void
    {
        static::created(function ($model) {
            ModelEventSubscriber::onCreate($model);
        });
    }
}