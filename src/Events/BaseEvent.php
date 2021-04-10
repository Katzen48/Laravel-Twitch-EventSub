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

class BaseEvent
{
    use Dispatchable;

    public Subscription $subscription;

    public function __construct($payload)
    {
        $this->parsePayload($payload);
    }

    public function parsePayload($payload): void
    {
        $this->parseSubscription($payload['subscription']);

        if (array_key_exists('event', $payload)) {
            $this->parseEvent($payload['event']);
        }
    }

    public function parseSubscription($subscription): void
    {
        $this->subscription = new Subscription();
        $this->subscription->id = $subscription['id'];
        $this->subscription->status = $subscription['status'];
        $this->subscription->type = $subscription['type'];
        $this->subscription->version = $subscription['version'];
        //$this->subscription->cost = $subscription['cost']; // TODO deactivated for testing purposes, as the twitch-cli does not support cost, yet
        $this->subscription->condition = $subscription['condition'];

        $this->subscription->transport = new \katzen48\Twitch\EventSub\Objects\Transport;
        $this->subscription->transport->method = $subscription['transport']['method'];
        $this->subscription->transport->callback = $subscription['transport']['callback'];

        $this->subscription->created_at = $this->parseCarbon($subscription['created_at']);
    }

    protected function parseCarbon($timestamp): CarbonInterface
    {
        preg_match('/^(?<pre>[\d\-:.T]+)\.(?<nano>\d{6,9})Z$/', $timestamp, $matches);

        return Carbon::createFromFormat(
            'Y-m-d\TH:i:s.u\Z',
            sprintf('%s.%dZ', $matches['pre'], substr($matches['nano'], 0, 6))
        );
    }

    public function parseEvent($event): void
    {

    }
}