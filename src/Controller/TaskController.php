<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Service\ControllerHandler\TaskHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TaskController.
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

    private $em;
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * TaskController constructor.
     *
     * @param TaskHandler          $taskHandler
     * @param FormFactoryInterface $form
     */
    public function __construct(FormFactoryInterface $formFactory, TaskHandler $taskHandler, EntityManagerInterface $em, TaskRepository $taskRepository)
    {
        $this->formFactory = $formFactory;
        $this->taskHandler = $taskHandler;
        $this->em = $em;
        $this->taskRepository = $taskRepository;
    }

    /**
     * @Route("/tasks", name="task_list")
     */
    public function listTask()
    {
        return $this->render('task/list.html.twig', ['tasks' => $this->taskRepository->findAllByCached()]);
    }

    /**
     * @Route("/tasks/done", name="task_done"))
     */
    public function listDoneTask()
    {
        return $this->render('task/done.html.twig', ['tasks' => $this->taskRepository->findDoneByCached()]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createTask(Request $request)
    {
        $task = new Task();
        $form = $this->formFactory->create(TaskType::class, $task)->handleRequest($request);

        if ($this->taskHandler->createTask($form, $task, $this->getUser())) {
            $this->addFlash('success', 'Votre tâche a bien été ajoutée');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     *
     * @param Request $request
     * @param Task    $task
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editTask(Request $request, Task $task)
    {
        $this->denyAccessUnlessGranted('edit', $task);
        $form = $this->formFactory->create(TaskType::class, $task)->handleRequest($request);

        if ($this->taskHandler->editTask($form, $task)) {
            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', ['form' => $form->createView(),
            'task' => $task, ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTask(Task $task)
    {
        $this->taskHandler->toggleTask($task);

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTask(Task $task)
    {
        $this->denyAccessUnlessGranted('delete', $task);

        $this->taskHandler->deleteTask($task);

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
