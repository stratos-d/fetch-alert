<?php

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

class IndexNotificationsRequest
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Positive]
        public int $userId,
    ) {}
}
