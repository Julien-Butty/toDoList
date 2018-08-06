<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 28/07/2018
 * Time: 00:38
 */

namespace App\Service\ControllerHandler;


use App\Entity\Task;
use App\Entity\User;
use App\Service\FormHandler\TaskTypeHandler;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class TaskHandler extends Controller
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
     * @var TaskTypeHandler
     */
    private $typeHandler;


    /**
     * TaskHandler constructor.
     * @param EntityManagerInterface $em
     * @param FormFactoryInterface $form
     * @param TaskTypeHandler $typeHandler
     */
    public function __construct(
        EntityManagerInterface $em,
        FormFactoryInterface $form,
        TaskTypeHandler $typeHandler
    )
    {
        $this->em = $em;
        $this->form = $form;
        $this->typeHandler = $typeHandler;
    }


    /**
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createTask(Request $request, User $user)
    {
        $task = new Task();
        $task->setUser($user);

        $form = $this->form->create(TaskType::class, $task);
        $form->handleRequest($request);

        $this->typeHandler->handleForm($form, $task);

        return $form;
    }

    /**
     * @param Request $request
     * @param Task $task
     * @return \Symfony\Component\Form\FormInterface
     */
    public function editTask(Request $request, Task $task)
    {
        $form = $this->form->create(TaskType::class, $task);
        $form->handleRequest($request);

        $this->typeHandler->handleForm($form, $task);

        return $form;

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