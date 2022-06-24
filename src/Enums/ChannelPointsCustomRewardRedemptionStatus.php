<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 5:14 PM
 */

namespace katzen48\Twitch\EventSub\Enums;

class ChannelPointsCustomRewardRedemptionStatus
{
    public const FULFILLED = 'FULFILLED';

    public const UNFULFILLED = 'UNFULFILLED';

    public const CANCELLED = 'CANCELLED';

    public const EVENTSUB_FULFILLED = 'fulfilled';

    public const EVENTSUB_UNFULFILLED = 'unfulfilled';

    public const EVENTSUB_CANCELLED = 'cancelled';
}
