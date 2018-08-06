<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 06/08/2018
 * Time: 08:19
 */

namespace App\Service\ControllerHandler;


use App\Entity\User;
use App\Service\FormHandler\UserTypeHandler;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class UserHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var FormFactoryInterface
     */
    private $form;
    /**
     * @var UserTypeHandler
     */
    private $typeHandler;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $form, UserTypeHandler $typeHandler)
    {
        $this->em = $em;
        $this->form = $form;
        $this->typeHandler = $typeHandler;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createUser(Request $request)
    {
        $user = new User();

        $form = $this->form->create(UserType::class, $user);
        $form->handleRequest($request);

        $this->typeHandler->handleForm($form, $user);

        return $form;
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\Form\FormInterface
     */
    public function editUser(Request $request, User $user)
    {
        $form = $this->form->create(UserType::class, $user);
        $form->handleRequest($request);

        $this->typeHandler->handleForm($form, $user);

        return $form;
    }

}