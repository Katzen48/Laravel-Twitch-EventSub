<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\User;

use katzen48\Twitch\EventSub\Events\BaseEvent;
use romanzipp\Twitch\Enums\EventSubType;

/**
 * Even though no scope is required, a client id with Scope::USER_READ_EMAIL returns $email and $emailVerified
 */
class UserUpdateEvent extends BaseEvent
{
    protected static string $type = EventSubType::USER_UPDATE;

    protected static string $version = '1';

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

    public static function subscribe(string $userId, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo(self::getVersion(), [
            'user_id' => $userId,
        ], false, $callbackUrl);
    }
}
