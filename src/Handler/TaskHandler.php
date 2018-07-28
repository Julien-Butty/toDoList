<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 28/07/2018
 * Time: 00:38
 */

namespace App\Handler;


use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\HttpFoundation\RequestStack;

class TaskHandler extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var FormInterface
     */
    private $form;
    /**
     * @var EngineInterface
     */
    private $templating;


    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, FormFactoryInterface $form, EngineInterface $templating)
    {
        $this->entityManager = $entityManager;

        $this->requestStack = $requestStack;

        $this->form = $form;

        $this->templating = $templating;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createTask()
    {
        $task = new Task();
        
        $form = $this->form->create(TaskType::class);

        $form->handleRequest($this->requestStack->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {


            $task->setUser($this->getUser());
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->templating->renderResponse('task/create.html.twig', [ 'form' => $form->createView()]);

    }

}