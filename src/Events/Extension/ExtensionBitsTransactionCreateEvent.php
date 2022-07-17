<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Extension;

use katzen48\Twitch\EventSub\Events\BaseEvent;
use romanzipp\Twitch\Enums\EventSubType;

class ExtensionBitsTransactionCreateEvent extends BaseEvent
{
    protected static string $type = EventSubType::EXTENSION_BITS_TRANSACTION_CREATE;

    protected static string $version = '1';

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

    public static function subscribe(string $extensionClientId, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo(self::getVersion(), [
            'extension_client_id' => $extensionClientId,
        ], false, $callbackUrl);
    }
}
