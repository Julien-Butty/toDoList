<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 07/08/2018
 * Time: 10:36.
 */

namespace App\tests\Doctrine;

use App\Doctrine\HashPasswordListener;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\UnitOfWork;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HashPasswordListenerTest extends TestCase
{
    public function testPrePersist()
    {
        $mockEncoder = $this->getMockBuilder(UserPasswordEncoderInterface::class)->disableOriginalConstructor()->getMock();

        $mockArgs = $this->getMockBuilder(LifecycleEventArgs::class)->disableOriginalConstructor()->getMock();

        $hashPass = new HashPasswordListener($mockEncoder);

        $user = new User();
        $user->setPlainPassword('123');

        $mockArgs->expects($this->once())->method('getEntity')->willReturn($user);

        $hashPass->prePersist($mockArgs);
    }

    public function testPreUpdate()
    {
        $mockEncoder = $this->getMockBuilder(UserPasswordEncoderInterface::class)->disableOriginalConstructor()->getMock();

        $mockArgs = $this->getMockBuilder(LifecycleEventArgs::class)->disableOriginalConstructor()->getMock();

        $hashPass = new HashPasswordListener($mockEncoder);

        $user = new User();
        $user->setPlainPassword('123');

        $classMetadata = $this->createMock(ClassMetadata::class);

        $entityManager = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();
        $entityManager
            ->method('getClassMetadata')
            ->willReturn($classMetadata);

        $unitOfWork = $this->getMockBuilder(UnitOfWork::class)->disableOriginalConstructor()->getMock();

        $entityManager
            ->method('getUnitOfWork')
            ->willReturn($unitOfWork);

        $lifeCycleEventArgs = new LifecycleEventArgs($user, $entityManager);

        $hashPass->preUpdate($lifeCycleEventArgs);

        $this->assertEquals('123', $user->getPlainPassword());
    }
}
