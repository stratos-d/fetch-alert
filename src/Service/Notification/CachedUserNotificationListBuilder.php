<?php

namespace App\Service\Notification;

use App\Entity\User;
use App\Model\Notification;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CachedUserNotificationListBuilder
{
    private const int CACHE_TTL = 1;

    public function __construct(
        private readonly UserNotificationListBuilder $userNotificationListBuilder,
        #[Autowire(service: 'user_notifications.cache')]
        private readonly CacheInterface $cache,
    ) {}

    /**
     * @return array<int, Notification>
     *
     * @throws InvalidArgumentException
     */
    public function getAvailableNotifications(User $user): array
    {
        $key = 'notifications.'.$user->getId();

        return $this->cache->get($key, function (ItemInterface $item) use ($user): array {
            $item->expiresAfter(self::CACHE_TTL);

            return $this->userNotificationListBuilder->getAvailableNotifications($user);
        });
    }
}
