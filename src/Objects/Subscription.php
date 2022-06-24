<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:48 PM
 */

namespace katzen48\Twitch\EventSub\Objects;

use Carbon\CarbonInterface;

class Subscription
{
    public string $id;

    public string $status;

    public string $type;

    public string $version;

    public int $cost;

    public array $condition;

    public Transport $transport;

    public CarbonInterface $created_at;
}
