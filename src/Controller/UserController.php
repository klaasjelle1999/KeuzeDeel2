<?php

namespace App\Controller;

use App\Entity\User;
use App\FormType\UserEditFormType;
use App\FormType\UserFormType;
use App\Manager\UserManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 * @Route(path="/admin")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user")
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route(path="/users/create", name="create_user")
     * @param Request $request
     * @param UserManager $userManager
     * @return Response
     */
    public function create(Request $request, UserManager $userManager)
    {
        $form = $this->createForm(UserFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $userManager->createUser($data);

            return $this->redirectToRoute('user');
        }

        return $this->render('user/create.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/users/remove/view/{user}", name="view_remove_user")
     * @param User $user
     * @return Response
     */
    public function viewRemoveModal(User $user)
    {
        if (!$user instanceof User) {
            throw new NotFoundHttpException('Deze gebruiker is niet gevonden!');
        }

        return $this->render('user/user_delete_modal.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route(path="/users/remove/{user}", name="remove_user")
     * @param User $user
     * @return RedirectResponse
     */
    public function remove(User $user, UserManager $userManager)
    {
        if (!$user instanceof User) {
            throw new NotFoundHttpException('Deze gebruiker is niet gevonden!');
        }

        $userManager->removeUser($user);

        return $this->redirectToRoute('user');
    }

    /**
     * @Route(path="/user/edit/{user}", name="edit_user")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function edit(User $user, Request $request, UserManager $userManager)
    {
        if (!$user instanceof User) {
            throw new NotFoundHttpException('Deze gebruiker is niet gevonden!');
        }

        $form = $this->createForm(UserEditFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $userManager->editUser($user, $data);

            return $this->redirectToRoute('user');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
