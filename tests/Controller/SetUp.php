<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 15/07/2018
 * Time: 11:12
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

abstract class SetUp extends WebTestCase
{
    protected $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'main';

        $token = new UsernamePasswordToken('julien', null, $firewallName, array('ROLE_USER'));
        $session->set('_security_'.$firewallName, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}