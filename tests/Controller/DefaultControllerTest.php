<?php

namespace App\Tests\Controller;





use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultControllerTest extends WebTestCase
{

    private $client = null;
    private $authClient = null;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->authClient = static::createClient([],[
            'PHP_AUTH_USER' => 'julien',
            'PHP_AUTH_PW' => '123456',
        ]);
    }


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

        $crawler= $this->authClient->request('GET', '/');
        $this->assertEquals(200, $this->authClient->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->selectLink('Se déconnecter')->count());


    }
    public function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('admin', null, $firewallName,array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}