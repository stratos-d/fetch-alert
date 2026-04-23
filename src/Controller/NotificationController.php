<?php

namespace App\Controller;

use App\Dto\Request\IndexNotificationsRequest;
use App\Dto\Response\UserNotificationListItem;
use App\Model\Notification;
use App\Repository\UserRepository;
use App\Service\Notification\CachedUserNotificationListBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

class NotificationController extends AbstractController
{
    #[Route('/notifications', name: 'notifications_index', methods: ['GET'])]
    public function index(
        #[MapQueryString] IndexNotificationsRequest $request,
        UserRepository $userRepository,
        CachedUserNotificationListBuilder $cachedUserNotificationListBuilder,
    ): JsonResponse {

        $user = $userRepository->find($request->userId);
        if (! $user) {
            throw $this->createNotFoundException('User not found');
        }

        $notifications = $cachedUserNotificationListBuilder->getAvailableNotifications($user);

        $responseItems = array_map(
            callback: static fn (Notification $notification) => UserNotificationListItem::fromNotification($notification),
            array: $notifications,
        );

        return $this->json($responseItems);
    }
}
