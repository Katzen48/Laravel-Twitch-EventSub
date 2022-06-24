<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 3:28 PM
 */

namespace katzen48\Twitch\EventSub\Events\Drop;

use Illuminate\Support\Collection;
use katzen48\Twitch\EventSub\Events\BaseEvent;
use katzen48\Twitch\EventSub\Objects\DropEntitlementEvent;
use katzen48\Twitch\EventSub\Objects\DropEntitlementEventData;

class DropEntitlementGrantEvent extends BaseEvent
{
    public Collection|DropEntitlementEvent $events;

    public function parseEvent($event): void
    {
        $events = collect();

        foreach ($event as $item) {
            $dropEvent = new DropEntitlementEvent();
            $dropEvent->id = $item['id'];
            $dropEvent->data = new DropEntitlementEventData();
            $dropEvent->data->organizationId = $item['organization_id'];
            $dropEvent->data->categoryId = $item['category_id'];
            $dropEvent->data->categoryName = $item['category_name'];
            $dropEvent->data->campaignId = $item['campaign_id'];
            $dropEvent->data->userId = $item['user_id'];
            $dropEvent->data->userName = $item['user_name'];
            $dropEvent->data->userLogin = $item['user_login'];
            $dropEvent->data->entitlementId = $item['entitlement_id'];
            $dropEvent->data->benefitId = $item['benefit_id'];
            $dropEvent->data->createdAt = $this->parseCarbon($item['created_at']);

            $events->add($dropEvent);
        }
    }
}
