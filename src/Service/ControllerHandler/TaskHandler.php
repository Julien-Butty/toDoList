<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 28/07/2018
 * Time: 00:38.
 */

namespace App\Service\ControllerHandler;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;

class TaskHandler extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * TaskHandler constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    /**
     * @param FormInterface $taskType
     * @param Task          $task
     * @param User          $user
     *
     * @return bool
     */
    public function createTask(FormInterface $taskType, Task $task, User $user)
    {
        if ($taskType->isSubmitted() && $taskType->isValid()) {
            $task->setUser($user);
            $this->em->persist($task);
            $this->em->flush();

            return true;
        }

        return false;
    }

    /**
     * @param FormInterface $taskType
     * @param Task          $task
     *
     * @return bool
     */
    public function editTask(FormInterface $taskType, Task $task)
    {
        if ($taskType->isSubmitted() && $taskType->isValid()) {
            $this->em->persist($task);
            $this->em->flush();

            return true;
        }

        return false;
    }

    /**
     * @param Task $task
     */
    public function toggleTask(Task $task)
    {
        $task->toggle(!$task->isDone());

        $this->em->flush();
    }

    /**
     * @param Task $task
     */
    public function deleteTask(Task $task)
    {
        $this->em->remove($task);

        $this->em->flush();
    }
}
