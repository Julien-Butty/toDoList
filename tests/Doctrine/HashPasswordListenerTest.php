<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 07/08/2018
 * Time: 10:36
 */

namespace App\tests\Doctrine;


use App\Doctrine\HashPasswordListener;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Tests\Encoder\UserPasswordEncoderTest;

class HashPasswordListenerTest extends TestCase
{


    public function testPrePersist()
    {
        $mockEncoder = $this->getMockBuilder(UserPasswordEncoderInterface::class)->disableOriginalConstructor()->getMock();
        $mockArgs = $this->getMockBuilder(LifecycleEventArgs::class)->disableOriginalConstructor()->getMock();

        $hashPass = new HashPasswordListener($mockEncoder);

        $user = new User();
        $user->setPlainPassword('123');

        $mockArgs->expects()->method('getEntity')->with(gettype($user))->willReturn(true);

        $hashPass->prePersist($mockArgs);

        dump($mockArgs);





    }


}