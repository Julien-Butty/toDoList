<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Service\ControllerHandler\TaskHandler;
use App\Security\TaskVoter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class TaskController extends Controller
{
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
     * @param TaskHandler $handler
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, TaskHandler $handler)
    {
        $form = $handler->createTask($request,$this->getUser());

        if ($form->isSubmitted()) {

            $this->addFlash('success', 'Votre tâche a bien été ajoutée');

            return $this->redirectToRoute('task_list');
        }

       return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Request $request, TaskHandler $handler, Task $task)
    {
        $form = $handler->editTask($request, $task);

        if ($form->isSubmitted()){

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
    public function toggleTaskAction(Task $task, TaskHandler $handler)
    {
        $handler->toggleTask($task);

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task, TaskHandler $handler)
    {
        $this->denyAccessUnlessGranted('delete', $task);
        $handler->deleteTask($task);

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
