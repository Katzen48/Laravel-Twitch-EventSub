# Laravel Twitch EventSub Library

<a href="https://packagist.org/packages/katzen48/laravel-twitch-eventsub"><img src="https://img.shields.io/packagist/dt/katzen48/laravel-twitch-eventsub" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/katzen48/laravel-twitch-eventsub"><img src="https://img.shields.io/packagist/v/katzen48/laravel-twitch-eventsub" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/katzen48/laravel-twitch-eventsub"><img src="https://img.shields.io/packagist/l/katzen48/laravel-twitch-eventsub" alt="License"></a>

## Introduction

This package provides support for subscribing to [Twitch EventSub](https://dev.twitch.tv/docs/eventsub/).
It's based on [laravel-twitch](https://github.com/romanzipp/laravel-twitch) and fully compatible.

## Features

- Create Twitch EventSub subscriptions via webhooks
- Subscribe to the received events on a per-event basis through the dedicated classes
- Define events, to subscribe to, whenever a specific model is saved to the database

## Installation

First, install [laravel-twitch](https://github.com/romanzipp/laravel-twitch).  
Please refer to their documentation.  

After laravel-twitch is installed and configured, install laravel-twitch-eventsub from composer
```shell
composer require katzen48/laravel-twitch-eventsub
```

The config can be published with
```shell
php artisan vendor:publish --tag=config
```

## Configuration

After you published the config, you can find it in ``config/twitch-eventsub.php`` and it looks like this:
```php
<?php

return [
    'callback_url' => env('TWITCH_HELIX_EVENTSUB_CALLBACK_URL', '/twitch/eventsub/webhook'), // Endpoint, the webhooks get sent to
];
```

## Consume EventSub events

Even when you don't subscribe to eventsub using this library, a route is registered, which
defaults to ``{APP_URL}/twitch/eventsub/webhook``. When you subscribe to EventSub and use this URL as a callback,
received events are parsed into dedicated events classes, which event listeners can subscribed to, individually.

To subscribe to an event, first create a listener with ``php artisan make:listener <Name>`` and add the event it should
subscribe to as a parameter to the ``handle()`` function.
```php
<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use katzen48\Twitch\EventSub\Events\Channel\ChannelSubscribeEvent;

class SubscriptionListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ChannelSubscribeEvent $event)
    {
        // Do something
    }
}
```

To bind the listener to an event, add the listener to the ``$listen`` array in your **EventServiceProvider**
```php
<?php

namespace App\Providers;

use App\Listeners\SubscriptionListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use katzen48\Twitch\EventSub\Events\Channel\ChannelSubscribeEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ChannelSubscribeEvent::class => [ // The Event, to subscribe to
            SubscriptionListener::class, // The Listener
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
```

There you go.
Your listener now gets incoming events of type ``channel.subscribe`` from the Twitch EventSub.

## Subscribe to Twitch EventSub on model save

Sometimes it is necessary, that newly created instances of a model trigger a subscription to the Twitch EventSub
e.g. a User logged in for the first time.
This behavior can be automated with the static ``SubscribesEventSubs`` trait.

Add the trait ``SubscribesEventSubs`` to your model.
Next add a static variable called ``$eventSubs`` to your model with the events to subscribe to and the conditions,
mapped to the attributes of your model.
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use katzen48\Twitch\EventSub\Traits\SubscribesEventSubs;
use romanzipp\Twitch\Enums\EventSubType;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SubscribesEventSubs;

    public static array $eventSubs = [
        EventSubType::CHANNEL_UPDATE => [ // The Event Type (from laravel-twitch)
            'broadcaster_user_id' => 'id', // The conditions from the EventSub documentation and the model attributes
        ],
    ];

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'email_verified_at' => 'datetime',
    ];
}
```

Now, whenever the ``created`` event is fired on that model, a subscription to the ``channel.update`` event tyoe is made.
The ``id`` property of the model is automatically inserted for ``broadcaster_user_id``.