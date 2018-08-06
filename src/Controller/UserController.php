<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\ControllerHandler\UserHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 * @Security("is_granted('ROLE_ADMIN')")
 */
class UserController extends Controller
{
    /**
     * @Route("/users", name="user_list")
     */
    public function listAction()
    {
        return $this->render('user/list.html.twig', ['users' => $this->getDoctrine()->getRepository(User::class)->findAll()]);
    }

    /**
     * @Route("/users/create", name="user_create")
     * @param Request $request
     * @param UserHandler $userHandler
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, UserHandler $userHandler )
    {
        $form = $userHandler->createUser($request);

        if ($form->isSubmitted()) {

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     * @param Request $request
     * @param User $user
     * @param UserHandler $userHandler
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, User $user, UserHandler $userHandler)
    {
        $form = $userHandler->editUser($request, $user);

        if ($form->isSubmitted()) {


            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
