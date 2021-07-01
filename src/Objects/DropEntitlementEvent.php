<?php
/**
 * User: Katzen48
 * Date: 7/1/2021
 * Time: 7:22 PM
 */

namespace katzen48\Twitch\EventSub\Objects;


class DropEntitlementEvent
{
    public string $id;

    public DropEntitlementEventData $data;
}