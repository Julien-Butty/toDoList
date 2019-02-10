<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 22/07/2018
 * Time: 12:42.
 */

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new Task();
    }

    public function testGetterAndSetters()
    {
        $this->object->setCreatedAt(new \DateTime('2018-07-22 10:35:00'));
        $this->assertEquals(new \DateTime('2018-07-22 10:35:00'), $this->object->getCreatedAt());

        $this->object->setTitle('test');
        $this->assertEquals('test', $this->object->getTitle());

        $this->object->setContent('test');
        $this->assertEquals('test', $this->object->getContent());

        $this->object->setUser($this->createMock(User::class));
        $this->assertEquals($this->createMock(User::class), $this->object->getUser());
    }

    public function testToggle()
    {
        $this->assertFalse($this->object->isDone());

        $this->object->toggle(true);
        $this->assertTrue($this->object->isDone());
    }
}
