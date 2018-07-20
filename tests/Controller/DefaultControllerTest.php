<?php

namespace App\Tests\Controller;


class DefaultControllerTest extends SetUp
{

    public function testNotLoggedHomepage()
    {

        $this->client->request('GET', '/');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->selectButton('Se connecter'));
    }

    public function testloggedInHomepage()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
}


}