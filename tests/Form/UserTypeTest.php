<?php

namespace App\tests\Form;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitForm()
    {
        $user = new User();

        $formData = [
            'username' => 'test',
            'plainPassword' => [
                'first' => '123456',
                'second' => '123456',
            ],
            'email' => 'ju@adresse.com',
            'roles' => 'ROLES_USER',
            'active' => true,
        ];

        $form = $this->factory->create(UserType::class, $user);

        $user->setUsername('test');
        $user->setPlainPassword('123456');
        $user->setEmail('ju@adresse.com');
        $user->setRoles(['ROLES_USER']);
        $user->setActive(true);

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($user, $form->getData());
    }

    protected function getExtensions()
    {
        return [new ValidatorExtension(Validation::createValidator())];
    }
}
