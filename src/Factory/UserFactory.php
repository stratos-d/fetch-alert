<?php

namespace App\Factory;

use App\Entity\User;
use App\Enum\UserStatus;
use DateTimeImmutable;
use Override;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<User>
 */
final class UserFactory extends PersistentObjectFactory
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
        return User::class;
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
            'countryCode' => self::faker()->countryCode(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'email' => self::faker()->safeEmail(),
            'isPremium' => self::faker()->boolean(),
            'status' => self::faker()->randomElement(UserStatus::cases()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[Override]
    protected function initialize(): static
    {
        return $this;
        // ->afterInstantiate(function(User $user): void {})
    }
}
