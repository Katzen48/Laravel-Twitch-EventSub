<?php
/**
 * User: Katzen48
 * Date: 6/19/2021
 * Time: 8:32 PM
 */

namespace katzen48\Twitch\EventSub\Objects;


class ChannelPollChoiceProgressed extends ChannelPollChoice
{
    public int $bitsVotes;

    public int $channelPointsVotes;

    public int $votes;
}