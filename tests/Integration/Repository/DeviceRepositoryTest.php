<?php

declare(strict_types=1);

namespace App\Tests\Integration\Repository;

use App\Enum\DeviceType;
use App\Factory\DeviceFactory;
use App\Factory\UserFactory;
use App\Repository\DeviceRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Attribute\ResetDatabase;

#[ResetDatabase]
class DeviceRepositoryTest extends KernelTestCase
{
    private DeviceRepository $repository;

    protected function setUp(): void
    {
        $this->repository = static::getContainer()->get(DeviceRepository::class);
    }

    public function test_user_has_device_type_returns_true_when_user_has_device(): void
    {
        $user = UserFactory::createOne();
        DeviceFactory::createOne(['user' => $user, 'type' => DeviceType::Android]);

        self::assertTrue($this->repository->userHasDeviceType($user, DeviceType::Android));
    }

    public function test_user_has_device_type_returns_false_when_doesnt_have_device(): void
    {
        $user = UserFactory::createOne();
        DeviceFactory::createOne(['user' => $user, 'type' => DeviceType::Ios]);
        DeviceFactory::createOne(['user' => $user, 'type' => DeviceType::Windows]);

        self::assertFalse($this->repository->userHasDeviceType($user, DeviceType::Android));
    }

    public function test_user_has_device_type_returns_false_when_other_user_has_device(): void
    {
        $otherUser = UserFactory::createOne();
        DeviceFactory::createOne(['user' => $otherUser, 'type' => DeviceType::Android]);

        $user = UserFactory::createOne();

        self::assertFalse($this->repository->userHasDeviceType($user, DeviceType::Android));
    }
}
