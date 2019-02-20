<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 22/07/2018
 * Time: 12:09.
 */

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new User();
    }

    public function testGetterAndSetter()
    {
        $this->object->setUsername('test');
        $this->assertEquals('test', $this->object->getUsername());

        $this->object->setPassword('test');
        $this->assertEquals('test', $this->object->getPassword());

        $this->object->setEmail('test');
        $this->assertEquals('test', $this->object->getEmail());

        $this->object->setRoles(['ROLE_USER']);
        $this->assertEquals(['ROLE_USER'], $this->object->getRoles());

        $this->object->setPlainPassword('test');
        $this->assertEquals('test', $this->object->getPlainPassword());

        $task = new Task();
        $user = new User();
        $task->setUser($user);

        $this->object->addTask($task);
        $this->assertInstanceOf(ArrayCollection::class, $this->object->getTasks());

        $this->assertNull($this->object->getSalt());

        $this->object->eraseCredentials();
        $this->assertNull($this->object->getPlainPassword());
    }
}
