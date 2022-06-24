<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:45 PM
 */

namespace katzen48\Twitch\EventSub\Events\EventSub;

use katzen48\Twitch\EventSub\Events\BaseEvent;

class CallbackVerificationEvent extends BaseEvent
{
    public string $challenge;

    public function parsePayload($payload): void
    {
        parent::parsePayload($payload);

        $this->challenge = $payload['challenge'];
    }
}
