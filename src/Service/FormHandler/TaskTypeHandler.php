<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 03/08/2018
 * Time: 21:25
 */

namespace App\Service\FormHandler;


use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;


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

    /**
     * @param FormInterface $taskType
     * @param Task $task
     * @return bool
     */
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