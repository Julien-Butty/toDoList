<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 28/07/2018
 * Time: 00:38
 */

namespace App\Handler;


use App\Controller\TaskController;
use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class TaskHandler extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FormFactoryInterface
     */
    private $form;
    /**
     * @var EngineInterface
     */
    private $templating;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var RouterInterface
     */
    private $router;


    public function __construct(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $form,
        EngineInterface $templating,
        TokenStorageInterface $tokenStorage,
        RouterInterface $router
    )
    {
        $this->entityManager = $entityManager;
        $this->form = $form;
        $this->templating = $templating;
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }


    public function createTask(Request $request, User $user)
    {
        $task = new Task();

        $form = $this->form->create(TaskType::class,$task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task->setUser($user);
            $this->entityManager->persist($task);
            $this->entityManager->flush();
            $request->getSession()->getFlashBag()->add('success', 'La tâche a été bien été ajoutée.');

            return new RedirectResponse($this->router->generate('task_list', ['task'=>$this->entityManager->getRepository(Task::class)->findAll()]));

        }

        return $this->templating->renderResponse('task/create.html.twig', [ 'form' => $form->createView()]);

    }

}