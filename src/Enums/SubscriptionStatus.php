<?php
/**
 * User: Katzen48
 * Date: 4/7/2021
 * Time: 2:50 PM
 */

namespace katzen48\Twitch\EventSub\Enums;

class SubscriptionStatus
{
    public const ENABLED = 'enabled';

    public const VERIFICATION_PENDING = 'webhook_callback_verification_pending';

    public const VERIFICATION_FAILED = 'webhook_callback_verification_failed';

    public const FAILURES_EXCEEDED = 'notification_failures_exceeded';

    public const REVOKED = 'authorization_revoked';

    public const USER_REMOVED = 'user_removed';
}
