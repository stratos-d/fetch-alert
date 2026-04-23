<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Notification\Resolver;

use App\Factory\UserFactory;
use App\Repository\DeviceRepository;
use App\Service\Notification\Resolver\SetupAndroidSpainNotification;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SetupAndroidSpainNotificationTest extends TestCase
{
    #[DataProvider('eligibilityProvider')]
    public function test_is_eligible_returns_correct_result(
        bool $expected,
        bool $isPremium,
        string $countryCode,
        ?DateTimeImmutable $lastActiveAt,
        bool $hasAndroidDevice,
    ): void {
        $user = UserFactory::new([
            'isPremium' => $isPremium,
            'countryCode' => $countryCode,
            'lastActiveAt' => $lastActiveAt,
        ])->withoutPersisting()->create();

        $deviceRepository = $this->createStub(DeviceRepository::class);
        $deviceRepository->method('userHasDeviceType')->willReturn($hasAndroidDevice);

        $resolver = new SetupAndroidSpainNotification([], $deviceRepository);

        self::assertSame($expected, $resolver->isEligible($user));
    }

    public static function eligibilityProvider(): iterable
    {
        yield 'eligible when all criteria match' => [true, false, 'ES', new DateTimeImmutable('-10 days'), false];
        yield 'ineligible when user is premium' => [false, true, 'ES', new DateTimeImmutable('-10 days'), false];
        yield 'ineligible when country is not ES' => [false, false, 'FR', new DateTimeImmutable('-10 days'), false];
        yield 'ineligible when active within last 7 days' => [false, false, 'ES', new DateTimeImmutable('-1 day'), false];
        yield 'ineligible when user never active' => [false, false, 'ES', null, false];
        yield 'ineligible when user already has an Android device' => [false, false, 'ES', new DateTimeImmutable('-10 days'), true];
    }
}
