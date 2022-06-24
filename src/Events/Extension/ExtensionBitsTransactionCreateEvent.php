<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Extension;

use katzen48\Twitch\EventSub\Events\BaseEvent;

class ExtensionBitsTransactionCreateEvent extends BaseEvent
{
    public string $extensionClientId;

    public string $userId;

    public string $userLogin;

    public string $userName;

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public mixed $product;

    public function parseEvent($event): void
    {
        $this->extensionClientId = $event['extension_client_id'];
        $this->userId = $event['user_id'];
        $this->userLogin = $event['user_login'];
        $this->userName = $event['user_name'];
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->product = $event['product'];
    }
}
