<?php

namespace FAb\SensorsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class jsonControllerTest extends WebTestCase
{
    public function testListstation()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listStation');
    }

}
