<?php


namespace App\tests\Service\EventListener;


use App\Entity\Task;
use App\Service\EventListener\TaskSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping\EntityListeners;
use PHPUnit\Framework\TestCase;
use Predis\ClientInterface;
use Snc\RedisBundle\Client\Phpredis\Client;



class TaskSubscriberTest extends TestCase
{
    public function testPostPersist()
    {
        $cacheDriver = $this->getMockBuilder(ClientInterface::class)->disableOriginalConstructor()->getMock();
        $task = new  Task();
        $mockArgs = $this->getMockBuilder(LifecycleEventArgs::class)->disableOriginalConstructor()->getMock();


        $sub = new TaskSubscriber($cacheDriver);
        $this->assertNull( $sub->postPersist($task, $mockArgs));
    }

    public function testPostUpdate()
    {
        $cacheDriver = $this->getMockBuilder(ClientInterface::class)->disableOriginalConstructor()->getMock();
        $task = new  Task();
        $mockArgs = $this->getMockBuilder(LifecycleEventArgs::class)->disableOriginalConstructor()->getMock();


        $sub = new TaskSubscriber($cacheDriver);
        $this->assertNull( $sub->postPersist($task, $mockArgs));
    }

    public function testPostRemove()
    {
        $cacheDriver = $this->getMockBuilder(ClientInterface::class)->disableOriginalConstructor()->getMock();
        $task = new  Task();
        $mockArgs = $this->getMockBuilder(LifecycleEventArgs::class)->disableOriginalConstructor()->getMock();


        $sub = new TaskSubscriber($cacheDriver);
        $this->assertNull( $sub->postPersist($task, $mockArgs));
    }

}