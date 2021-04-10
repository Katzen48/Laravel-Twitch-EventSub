<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 5:25 PM
 */

namespace katzen48\Twitch\EventSub\Objects;


class HypeTrainContribution
{
    public string $contributorId;
    public string $contributorLogin;
    public string $contributorName;
    public string $type;
    public int $total;
}