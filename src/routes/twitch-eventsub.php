<?php

Route::post(
    config('twitch-eventsub.callback_url'),
    [romanzipp\Twitch\Http\Controllers\EventSubController::class, 'handleWebhook']
);