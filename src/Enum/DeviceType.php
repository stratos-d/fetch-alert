<?php

declare(strict_types=1);

namespace App\Enum;

enum DeviceType: string
{
    case Android = 'android';
    case Ios = 'ios';
    case Windows = 'windows';
}
