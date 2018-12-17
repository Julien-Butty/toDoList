<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 06/08/2018
 * Time: 10:03
 */

namespace App\Tests\Controller;


use App\Entity\User;

class UserControllerTest extends SetUp
{
    public function testListAuthorized()
    {
        $this->logIn('admin');
        $this->client->request('GET', '/users');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testListNoAuthorized()
    {
        $this->logIn();
        $this->client->request('GET', '/users');

        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateUser()
    {
        $this->logIn('admin');
        $crawler = $this->client->request('GET', '/users/create');

        $buttonCrawlerNode = $crawler->selectButton('Ajouter');

        $form = $buttonCrawlerNode->form([
            'user[username]'=> 'TestCreateUser',
            'user[plainPassword]'=>array('first'=>'123', 'second'=>'123'),

            'user[email]'=>'user@gmail.com',
            'user[roles]'=>array('ROLE_USER','ROLE_ADMIN'),
            'user[active]'=> 1
        ]);


        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("TestCreateUser")')->count());
    }

    public function testEditUser()
    {
        $this->logIn('admin');

        $user = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class)->findOneBy(array('username'=>'TestCreateUser'));
        $id = $user->getId();

        $crawler = $this->client->request('GET', '/users/'.$id.'/edit');

        $buttonCrawlerNode = $crawler->selectButton('Modifier');

        $form = $buttonCrawlerNode->form([
            'user[username]'=> 'TestEditUser',
            'user[plainPassword]'=>array('first'=>'123', 'second'=>'123'),

            'user[email]'=>'user@gmail.com',
            'user[roles]'=>array('ROLE_USER','ROLE_ADMIN'),
            'user[active]' => 1
        ]);

        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("TestEditUser")')->count());

        /*==============  DELETE USER AFTER TEST PASSING  =================*/
        $userEdit = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class)->findOneBy(array('username'=>'TestEditUser'));

        $this->client->getContainer()->get('doctrine.orm.entity_manager')->remove($userEdit);
        $this->client->getContainer()->get('doctrine.orm.entity_manager')->flush();

    }

}