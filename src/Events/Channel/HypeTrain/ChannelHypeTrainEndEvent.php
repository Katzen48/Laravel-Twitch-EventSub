<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Channel\HypeTrain;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use katzen48\Twitch\EventSub\Events\BaseEvent;
use katzen48\Twitch\EventSub\Objects\HypeTrainContribution;
use romanzipp\Twitch\Enums\EventSubType;
use romanzipp\Twitch\Enums\Scope;

class ChannelHypeTrainEndEvent extends BaseEvent
{
    protected static string $type = EventSubType::CHANNEL_HYPE_TRAIN_END;
    protected static string $version = '1';

    protected static array $scopes = [
        Scope::CHANNEL_READ_HYPE_TRAIN,
    ];

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public int $level;

    public int $total;

    /**
     * @var Collection|HypeTrainContribution
     */
    public $topContributions;

    public CarbonInterface $startedAt;

    public CarbonInterface $endedAt;

    public CarbonInterface $cooldownEndsAt;

    public function parseEvent($event): void
    {
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->level = $event['level'];
        $this->total = $event['total'];
        $this->startedAt = $this->parseCarbon($event['started_at']);
        $this->endedAt = $this->parseCarbon($event['ended_at']);
        $this->cooldownEndsAt = $this->parseCarbon($event['cooldown_ends_at']);

        $this->topContributions = collect();
        foreach ($event['top_contributions'] as $item) {
            $contribution = new HypeTrainContribution;
            $contribution->contributorId = $item['user_id'];
            $contribution->contributorLogin = $item['user_login'];
            $contribution->contributorName = $item['user_name'];
            $contribution->type = $item['type'];
            $contribution->total = $item['total'];

            $this->topContributions->add($contribution);
        }
    }

    public static function subscribe(string $broadcasterId, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo(self::getVersion(), [
            'broadcaster_user_id' => $broadcasterId,
        ], false, $callbackUrl);
    }
}
