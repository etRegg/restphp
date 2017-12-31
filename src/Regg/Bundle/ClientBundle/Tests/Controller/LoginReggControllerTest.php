<?php

namespace Regg\Bundle\ClientBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginReggControllerTest extends WebTestCase
{
    public function testLoginregg()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/loginregg');
    }

    public function testRegisterregg()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/registerregg');
    }

}
