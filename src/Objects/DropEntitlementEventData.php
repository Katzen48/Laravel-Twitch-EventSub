<?php
/**
 * User: Katzen48
 * Date: 7/1/2021
 * Time: 7:23 PM
 */

namespace katzen48\Twitch\EventSub\Objects;


use Carbon\CarbonInterface;

class DropEntitlementEventData
{
    public string $organizationId;

    public string $categoryId;

    public string $categoryName;

    public string $campaignId;

    public string $userId;

    public string $userName;

    public string $userLogin;

    public string $entitlementId;

    public string $benefitId;

    public CarbonInterface $createdAt;
}