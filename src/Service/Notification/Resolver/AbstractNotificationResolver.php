<?php

namespace App\Service\Notification\Resolver;

use App\Entity\User;
use App\Model\Notification;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.notification_resolver')]
abstract class AbstractNotificationResolver
{
    /**
     * @param array<string, array{
     *     title: string,
     *     description: string,
     *     cta?: string
     * }> $notificationsConfig
     */
    public function __construct(
        private readonly array $notificationsConfig,
    ) {}

    abstract public function isEligible(User $user): bool;

    public function buildNotification(): Notification
    {
        $key = $this->notificationKey();
        $config = $this->notificationsConfig[$key] ?? null;

        if ($config === null) {
            throw new RuntimeException(sprintf('Notification config "%s" not found.', $key));
        }

        return new Notification(
            $config['title'],
            $config['description'],
            $config['cta'] ?? null,
        );
    }

    abstract protected function notificationKey(): string;
}
