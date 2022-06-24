<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\User;

use katzen48\Twitch\EventSub\Events\BaseEvent;
use romanzipp\Twitch\Enums\EventSubType;

class UserUpdateEvent extends BaseEvent
{
    public const type = EventSubType::USER_UPDATE;

    public string $userId;

    public string $userLogin;

    public string $userName;

    public string $email;

    public bool $emailVerified;

    public string $description;

    public function parseEvent($event): void
    {
        $this->userId = $event['user_id'];
        $this->userLogin = $event['user_login'];
        $this->userName = $event['user_name'];
        $this->email = $event['email'] ?? null;
        $this->emailVerified = $event['email_verified'] ?? false;
        $this->description = $event['description'];
    }

    public function subscribe(string $userId, string $callbackUrl = null): ?string
    {
        return \katzen48\Twitch\EventSub\Facades\TwitchEventSub::subscribeEvent(self::type, '1', [
            'user_id' => $userId,
        ], false, $callbackUrl);
    }
}
