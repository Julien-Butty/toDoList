<?php


namespace App\tests\Security;


use App\Entity\User;
use App\Security\UserChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserCheckerTest extends TestCase
{
    /**
     *
     */
    public function testPreAuth()
    {
        $userInterface = $this->createMock(UserInterface::class);
        $user = new User();
        $user->setUsername('test');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setActive(1);


        $userInterface->expects($this->once())->method('getUserName')->willReturn($user->getUsername());
        $userInterface->expects($this->once())->method('getRoles')->willReturn($user->getRoles());


        $userChecker = new UserChecker();




        dump($userInterface);

        $this->assertEquals('Votre compte a été désactivé :(',$userChecker->checkPreAuth($userInterface));
    }
}