<?php

namespace App\Service\Notification;

use App\Entity\User;
use App\Model\Notification;
use App\Service\Notification\Resolver\AbstractNotificationResolver;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class UserNotificationListBuilder
{
    /**
     * @param  iterable<AbstractNotificationResolver>  $resolvers
     */
    public function __construct(
        #[AutowireIterator('app.notification_resolver')]
        private readonly iterable $resolvers
    ) {}

    /**
     * @return array<int, Notification>
     */
    public function getAvailableNotifications(User $user): array
    {
        $notifications = [];
        foreach ($this->resolvers as $resolver) {
            if ($resolver->isEligible($user)) {
                $notifications[] = $resolver->buildNotification();
            }
        }

        return $notifications;
    }
}
