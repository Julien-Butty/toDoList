<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 03/08/2018
 * Time: 21:25
 */

namespace App\Form\Handler;


use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class TaskTypeHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handleForm(FormInterface $taskType, Task $task):bool
    {

        if ($taskType->isSubmitted() && $taskType->isValid()) {

            $this->em->persist($task);
            $this->em->flush();

            return true;
        }
        return false;
    }



}