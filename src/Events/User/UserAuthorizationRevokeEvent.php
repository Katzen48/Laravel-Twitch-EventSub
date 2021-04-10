<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\User;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use katzen48\Twitch\EventSub\Events\BaseEvent;

class UserAuthorizationRevokeEvent extends BaseEvent
{
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
}