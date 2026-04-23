<?php

declare(strict_types=1);

namespace App\Dto\Response;

use App\Model\Notification;

final readonly class UserNotificationListItem
{
    public function __construct(
        public string $title,
        public string $description,
        public ?string $cta = null,
    ) {}

    public static function fromNotification(Notification $notification): self
    {
        return new self(
            $notification->getTitle(),
            $notification->getDescription(),
            $notification->getCta(),
        );
    }
}
