<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\User;

use katzen48\Twitch\EventSub\Events\BaseEvent;
use romanzipp\Twitch\Enums\EventSubType;

class UserAuthorizationRevokeEvent extends BaseEvent
{
    protected static string $type = EventSubType::USER_AUTHORIZATION_REVOKE;

    public string $clientId;

    public string $userId;

    public string $userLogin;

    public string $userName;

    public function parseEvent($event): void
    {
        $this->clientId = $event['client_id'];
        $this->userId = $event['user_id'];
        $this->userLogin = $event['user_login'];
        $this->userName = $event['user_name'];
    }

    public static function subscribe(string $clientId = null, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo('1', [
            'client_id' => $clientId ?? \katzen48\Twitch\EventSub\Facades\TwitchEventSub::getClientId(),
        ], false, $callbackUrl);
    }
}
