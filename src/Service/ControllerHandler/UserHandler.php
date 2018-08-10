<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 06/08/2018
 * Time: 08:19
 */

namespace App\Service\ControllerHandler;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;


class UserHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * UserHandler constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormInterface $userType
     * @param User $user
     * @return bool
     */
    public function createUser(FormInterface $userType, User $user )
    {
        if ($userType->isSubmitted() && $userType->isValid()) {

            $this->em->persist($user);
            $this->em->flush();

            return true;
        }

        return false;
    }

    /**
     * @param FormInterface $userType
     * @param User $user
     * @return bool
     */
    public function editUser(FormInterface $userType, User $user)
    {
        if ($userType->isSubmitted() && $userType->isValid()) {

            $this->em->persist($user);
            $this->em->flush();

            return true;
        }

        return false;
    }

}
