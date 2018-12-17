<?php


namespace App\tests\Security;


use App\Entity\User;
use App\Security\UserChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserCheckerTest extends TestCase
{
    /**
     *
     */
    public function testPreAuth()
    {

        $user = new User();
        $user->setUsername('test');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setActive(1);

        $userChecker = new UserChecker();

        $mockUser = $this->createMock(UserInterface::class);
        $this->assertNull($userChecker->checkPreAuth($mockUser));

        $this->assertNull($userChecker->checkPreAuth($user));
        $user->setActive(0);
        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->assertNull($userChecker->checkPreAuth($user));
    }

    public function testPostAuth()
    {

        $user = new User();
        $user->setUsername('test');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setActive(1);

        $userChecker = new UserChecker();

        $mockUser = $this->createMock(UserInterface::class);
        $this->assertNull($userChecker->checkPostAuth($mockUser));

        $this->assertNull($userChecker->checkPostAuth($user));
        $user->setActive(0);
        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->assertNull($userChecker->checkPostAuth($user));
    }


}