<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 06/08/2018
 * Time: 10:03.
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
        $this->client->request('GET', '/users/create');

        $formData = [
            'user' => [
                'username' => 'TestCreateUser',
                'plainPassword' => ['first' => '123', 'second' => '123'],

                'email' => 'user@gmail.com',
                'roles' => ['ROLE_USER', 'ROLE_ADMIN'],
                'active' => 1,
            ],
        ];

        $this->client->request(
        'POST',
            '/users/create',
            $formData
        );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testEditUser()
    {
        $this->logIn('admin');

        $user = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class)->findOneBy([]);
        $id = $user->getId();

        $this->client->request('GET', '/users/'.$id.'/edit');

        $formData = [
            'user' => [
                'username' => 'TestEditUser',
                'plainPassword' => ['first' => '123', 'second' => '123'],

                'email' => 'user@gmail.com',
                'roles' => ['ROLE_USER', 'ROLE_ADMIN'],
                'active' => 1,
            ],
        ];

        $this->client->request(
            'POST',
            '/users/create',
            $formData
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }
}
