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

class UserUpdateEvent extends BaseEvent
{
    public string $userId;

    public string $userLogin;

    public string $userName;

    public string $email;

    public string $description;

    public function parseEvent($event): void
    {
        $this->userId = $event['user_id'];
        $this->userLogin = $event['user_login'];
        $this->userName = $event['user_name'];
        $this->email = $event['email'] ?? null;
        $this->description = $event['description'];
    }
}