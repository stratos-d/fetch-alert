<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    public function test_application_is_alive(): void
    {
        $client = self::createClient();

        $client->request('GET', '/health');

        self::assertResponseIsSuccessful();
    }
}
