<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 12/07/2018
 * Time: 10:41
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class TaskControllerTest extends SetUp
{
    public function testListActionNotLoggedIn()
    {
        $this->client->request('GET', '/tasks');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->request('GET', '/login');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    public function testListAction()
    {
        $this->logIn();
        $this->client->request('GET', '/tasks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    }

    public function testCreateAction()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/tasks/create');

        $buttonCrawlerNode = $crawler->selectButton('Ajouter');
        $form = $buttonCrawlerNode->form(array(
            'task[title]' => 'Essai Test',
            'task[content]' => 'Essai Test'
        ));

        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Essai Test")')->count());
    }

    public function testEditAction()
    {
        $this->logIn();
        $task = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('App:Task')->findOneBy([]);
        $id = $task->getId();

        $crawler = $this->client->request('GET', '/tasks/'.$id.'/edit');

        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        $form = $buttonCrawlerNode->form(array(
            'task[title]' => 'Essai Test',
            'task[content]' => 'Essai Test'
        ));

        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Essai Test")')->count());


    }

}