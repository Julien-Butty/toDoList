<?php


namespace App\tests\Service\ControllerHandler;


use App\Service\ControllerHandler\UserHandler;

class UserHandlerTest
{
    public function testCreateUser()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $userType = $this->createMock(FormInterface::class);
        $user = new User();

        $userHandler = new UserHandler($entityManager);

        $userType->method('isSubmitted')->willReturn(true);
        $userType->method('isValid')->willReturn(true);

        $this->assertTrue($userHandler->createTask($userType,$user));
    }

    public function testEditUser()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $userType = $this->createMock(FormInterface::class);
        $user = new User();

        $userHandler = new UserHandler($entityManager);

        $userType->method('isSubmitted')->willReturn(true);
        $userType->method('isValid')->willReturn(true);

        $this->assertTrue($userHandler->editUser($userType, $user));
    }



}