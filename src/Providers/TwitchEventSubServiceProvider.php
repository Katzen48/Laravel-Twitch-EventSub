<?php

namespace katzen48\Twitch\EventSub\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use katzen48\Twitch\EventSub\EventMap;
use katzen48\Twitch\EventSub\TwitchEventSub;

/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:03 PM
 */
class TwitchEventSubServiceProvider extends \Illuminate\Support\ServiceProvider
{
    use EventMap;

    public function boot()
    {
        $this->publishes([
            dirname(__DIR__) . '/../config/twitch-eventsub.php' => config_path('twitch-eventsub.php'),
        ], 'config');

        /**
         * @var $events Dispatcher
         */
        $events = $this->app->make(Dispatcher::class);

        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/twitch-eventsub.php');
    }

    public function register()
    {
        parent::register();

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/../config/twitch-eventsub.php', 'twitch-eventsub'
        );

        $this->app->singleton(TwitchEventSub::class, function () {
            return new TwitchEventSub;
        });
    }

    public function provides()
    {
        return [TwitchEventSub::class];
    }
}