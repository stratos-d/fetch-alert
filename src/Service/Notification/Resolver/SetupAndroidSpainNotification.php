<?php

namespace App\Service\Notification\Resolver;

use App\Entity\User;
use App\Enum\DeviceType;
use App\Repository\DeviceRepository;
use DateTimeImmutable;

class SetupAndroidSpainNotification extends AbstractNotificationResolver
{
    public function __construct(
        array $notificationsConfig,
        private readonly DeviceRepository $deviceRepository,
    ) {
        parent::__construct($notificationsConfig);
    }

    public function isEligible(User $user): bool
    {
        if ($user->isPremium()) {
            return false;
        }
        if ($user->getCountryCode() !== 'ES') {
            return false;
        }
        if ($user->getLastActiveAt() === null || $user->getLastActiveAt() > new DateTimeImmutable('-7 days')) {
            return false;
        }
        if ($this->deviceRepository->userHasDeviceType($user, DeviceType::Android)) {
            return false;
        }

        return true;
    }

    protected function notificationKey(): string
    {
        return 'setup_android_es';
    }
}
