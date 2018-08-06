<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 06/08/2018
 * Time: 08:21
 */

namespace App\Service\FormHandler;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;


class UserTypeHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormInterface $userType
     * @param User $user
     * @return bool
     */
    public function handleForm(FormInterface $userType, User $user)
    {
        if($userType->isSubmitted() && $userType->isValid()) {

            $this->em->persist($user);
            $this->em->flush();

            return true;
        }

        return false;

    }
}
