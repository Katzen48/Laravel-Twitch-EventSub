<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:57 PM
 */

namespace katzen48\Twitch\EventSub\Events;

use Carbon\CarbonInterface;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Carbon;
use katzen48\Twitch\EventSub\Objects\Subscription;
use katzen48\Twitch\EventSub\Objects\Transport;

class BaseEvent
{
    use Dispatchable;

    public Subscription $subscription;

    public string $id;

    public int $retries;

    public CarbonInterface $timestamp;

    public function __construct(array $payload, string $id, int $retries, CarbonInterface $timestamp)
    {
        $this->parsePayload($payload);
        $this->id = $id;
        $this->retries = $retries;
        $this->timestamp = $timestamp;
    }

    public function parsePayload($payload): void
    {
        $this->parseSubscription($payload['subscription']);

        if (array_key_exists('event', $payload)) {
            $this->parseEvent($payload['event']);
        } elseif (array_key_exists('events', $payload)) {
            $this->parseEvent($payload['events']);
        }
    }

    public function parseSubscription($subscription): void
    {
        $this->subscription = new Subscription();
        $this->subscription->id = $subscription['id'];
        $this->subscription->status = $subscription['status'];
        $this->subscription->type = $subscription['type'];
        $this->subscription->version = $subscription['version'];
        $this->subscription->cost = $subscription['cost'];
        $this->subscription->condition = $subscription['condition'];

        $this->subscription->transport = new Transport;
        $this->subscription->transport->method = $subscription['transport']['method'];
        $this->subscription->transport->callback = $subscription['transport']['callback'];

        $this->subscription->created_at = $this->parseCarbon($subscription['created_at']);
    }

    protected function parseCarbon($timestamp): CarbonInterface
    {
        if (preg_match('/\.([\d]{9,})Z$/', $timestamp, $match)) {
            $length = strlen($match[1]) - 8;
            $timestamp = substr_replace($timestamp, '', ($length * -1) - 1, $length);
        }

        return Carbon::parse($timestamp, 'UTC');
    }

    public function parseEvent($event): void
    {
    }
}
