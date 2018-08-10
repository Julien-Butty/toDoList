<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Form\UserType;
use App\Service\ControllerHandler\TaskHandler;
use App\Security\TaskVoter;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * Class TaskController
 * @package App\Controller
 */
class TaskController extends Controller
{

    /**
     * @var FormFactory
     */
    private $formFactory;
    /**
     * @var TaskHandler
     */
    private $taskHandler;

    /**
     * TaskController constructor.
     * @param TaskHandler $taskHandler
     * @param FormFactoryInterface $form
     */
    public function __construct(FormFactoryInterface $formFactory,TaskHandler $taskHandler)
    {
        $this->formFactory = $formFactory;
        $this->taskHandler = $taskHandler;
    }

    /**
     *
     * @Route("/tasks", name="task_list")
     */
    public function listAction()
    {
        return $this->render('task/list.html.twig', ['tasks' => $this->getDoctrine()->getRepository(Task::class)->findAll()]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->formFactory->create(TaskType::class, $task)->handleRequest($request);

        if ($this->taskHandler->createTask($form, $task,$this->getUser())) {

            $this->addFlash('success', 'Votre tâche a bien été ajoutée');

            return $this->redirectToRoute('task_list');
        }

       return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     * @param Request $request
     * @param Task $task
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Task $task)
    {
        $form = $this->formFactory->create(TaskType::class, $task)->handleRequest($request);

        if ($this->taskHandler->editTask($form, $task)){

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        $this->taskHandler->toggleTask($task);

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task)
    {
        $this->denyAccessUnlessGranted('delete', $task);

        $this->taskHandler->deleteTask($task);

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
