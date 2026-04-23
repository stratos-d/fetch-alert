<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Notification;

use App\Factory\UserFactory;
use App\Model\Notification;
use App\Service\Notification\Resolver\AbstractNotificationResolver;
use App\Service\Notification\UserNotificationListBuilder;
use PHPUnit\Framework\TestCase;

class UserNotificationListBuilderTest extends TestCase
{
    public function test_get_available_notifications_returns_eligible_notifications(): void
    {
        $user = UserFactory::new()->withoutPersisting()->create();
        $expected = new Notification('Title', 'Description');

        $eligible = $this->createStub(AbstractNotificationResolver::class);
        $eligible->method('isEligible')->willReturn(true);
        $eligible->method('buildNotification')->willReturn($expected);

        $ineligible = $this->createMock(AbstractNotificationResolver::class);
        $ineligible->method('isEligible')->willReturn(false);
        $ineligible->expects(self::never())->method('buildNotification');

        $builder = new UserNotificationListBuilder([$eligible, $ineligible]);

        self::assertSame([$expected], $builder->getAvailableNotifications($user));
    }
}
