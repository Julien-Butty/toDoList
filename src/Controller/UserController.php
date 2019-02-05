<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\ControllerHandler\UserHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController.
 *
 * @Security("is_granted('ROLE_ADMIN')")
 */
class UserController extends Controller
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var UserHandler
     */
    private $userHandler;

    public function __construct(FormFactoryInterface $formFactory, UserHandler $userHandler)
    {
        $this->formFactory = $formFactory;
        $this->userHandler = $userHandler;
    }

    /**
     * @Route("/users", name="user_list")
     */
    public function listAction()
    {
        return $this->render('user/list.html.twig', ['users' => $this->getDoctrine()->getRepository(User::class)->findAll()]);
    }

    /**
     * @Route("/users/create", name="user_create")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createUser(Request $request)
    {
        $user = new User();
        $form = $this->formFactory->create(UserType::class, $user)->handleRequest($request);

        if ($this->userHandler->createUser($form, $user)) {
            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     *
     * @param Request     $request
     * @param User        $user
     * @param UserHandler $userHandler
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editUser(Request $request, User $user)
    {
        $form = $this->formFactory->create(UserType::class, $user)->handleRequest($request);

        if ($this->userHandler->editUser($form, $user)) {
            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
