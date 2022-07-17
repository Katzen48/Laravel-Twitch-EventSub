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

class ChannelHypeTrainProgressEvent extends BaseEvent
{
    protected static string $type = EventSubType::CHANNEL_HYPE_TRAIN_PROGRESS;

    protected static string $version = '1';

    protected static array $scopes = [
        Scope::CHANNEL_READ_HYPE_TRAIN,
    ];

    public string $broadcasterId;

    public string $broadcasterLogin;

    public string $broadcasterName;

    public int $level;

    public int $total;

    public int $progress;

    public int $goal;

    /**
     * @var Collection|HypeTrainContribution
     */
    public $topContributions;

    public HypeTrainContribution $lastContribution;

    public CarbonInterface $startedAt;

    public CarbonInterface $expiresAt;

    public function parseEvent($event): void
    {
        $this->broadcasterId = $event['broadcaster_user_id'];
        $this->broadcasterLogin = $event['broadcaster_user_login'];
        $this->broadcasterName = $event['broadcaster_user_name'];
        $this->level = $event['level'];
        $this->total = $event['total'];
        $this->progress = $event['progress'];
        $this->goal = $event['goal'];
        $this->startedAt = $this->parseCarbon($event['started_at']);
        $this->expiresAt = $this->parseCarbon($event['expires_at']);

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

        if (array_key_exists('last_contribution', $event)) {
            $this->lastContribution = new HypeTrainContribution;
            $this->lastContribution->contributorId = $event['last_contribution']['user_id'];
            $this->lastContribution->contributorLogin = $event['last_contribution']['user_login'];
            $this->lastContribution->contributorName = $event['last_contribution']['user_name'];
            $this->lastContribution->type = $event['last_contribution']['type'];
            $this->lastContribution->total = $event['last_contribution']['total'];
        }
    }

    public static function subscribe(string $broadcasterId, string $callbackUrl = null): ?string
    {
        return parent::subscribeTo(self::getVersion(), [
            'broadcaster_user_id' => $broadcasterId,
        ], false, $callbackUrl);
    }
}
