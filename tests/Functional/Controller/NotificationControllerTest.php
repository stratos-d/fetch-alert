<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Enum\DeviceType;
use App\Factory\DeviceFactory;
use App\Factory\UserFactory;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Attribute\ResetDatabase;

#[ResetDatabase]
class NotificationControllerTest extends WebTestCase
{
    public function test_eligible_user_receives_setup_android_notification(): void
    {
        $client = static::createClient();

        $user = UserFactory::createOne([
            'countryCode' => 'ES',
            'isPremium' => false,
            'lastActiveAt' => new DateTimeImmutable('-10 days'),
        ]);
        DeviceFactory::createOne(['user' => $user, 'type' => DeviceType::Ios]);

        $client->request('GET', '/notifications', ['userId' => $user->getId()]);

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');

        $payload = json_decode($client->getResponse()->getContent(), true, flags: JSON_THROW_ON_ERROR);

        self::assertIsArray($payload);
        $titles = array_column($payload, 'title');
        self::assertContains('Configurar dispositivo Android', $titles);
    }

    public function test_ineligible_user_receives_emppty_list(): void
    {
        $client = static::createClient();

        $user = UserFactory::createOne(['countryCode' => 'BR']);

        $client->request('GET', '/notifications', ['userId' => $user->getId()]);

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');

        $payload = json_decode($client->getResponse()->getContent(), true, flags: JSON_THROW_ON_ERROR);

        self::assertIsArray($payload);
        $titles = array_column($payload, 'title');
        self::assertContains('Configurar dispositivo Android', $titles);
    }
}
