<?php

namespace App\Factory;

use App\Entity\Device;
use App\Enum\DeviceType;
use DateTimeImmutable;
use Override;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Device>
 */
final class DeviceFactory extends PersistentObjectFactory
{
    /**
     * @see  https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct() {}

    #[Override]
    public static function class(): string
    {
        return Device::class;
    }

    /**
     * @see  https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[Override]
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'type' => self::faker()->randomElement(DeviceType::cases()),
            'user' => UserFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[Override]
    protected function initialize(): static
    {
        return $this;
        // ->afterInstantiate(function(Device $device): void {})
    }
}
