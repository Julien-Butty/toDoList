<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 12/07/2018
 * Time: 10:41.
 */

namespace App\Tests\Controller;

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

    public function testCreateAdminAction()
    {
        $this->logIn('admin');
        $crawler = $this->client->request('GET', '/tasks/create');

        $buttonCrawlerNode = $crawler->selectButton('Ajouter');
        $form = $buttonCrawlerNode->form([
            'task[title]' => 'Essai Admin',
            'task[content]' => 'Essai Admin',
        ]);

        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Essai Admin")')->count());
    }

    public function testEditAction()
    {
        $this->logIn();
        $task = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('App:Task')->findOneBy([]);
        $id = $task->getId();

        $crawler = $this->client->request('GET', '/tasks/'.$id.'/edit');

        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        $form = $buttonCrawlerNode->form([
            'task[title]' => 'Essai Test',
            'task[content]' => 'Essai Test',
        ]);

        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Essai Test")')->count());
    }

    public function testToggleTaskAction()
    {
        $this->logIn('admin');
        $task = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('App:Task')->findOneBy([]);
        $id = $task->getId();

        $crawler = $this->client->request('GET', '/tasks/'.$id.'/toggle');
        $crawler->selectButton('Marquer comme faite');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteAction()
    {
        $this->testCreateAdminAction();
        $this->logIn('admin');
        $task = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('App:Task')->findOneBy(['content' => 'Essai Admin']);
        $id = $task->getId();

        $crawler = $this->client->request('GET', '/tasks/'.$id.'/delete');
        $crawler->selectButton('supprimer');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteActionNoAuth()
    {
        $this->testCreateAdminAction();
        $this->logIn();

        $task = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('App:Task')->findOneBy(['content' => 'Essai Admin']);
        $id = $task->getId();

        $crawler = $this->client->request('GET', '/tasks/'.$id.'/delete');
        $crawler->selectButton('supprimer');

        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }
}
