<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IngredientTestController extends WebTestCase
{
    public function testIndex()
    {
        $client=static::createClient();
        $client->request('POST', '/ingredient/nouveau');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        
    }
}