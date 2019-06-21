<?php

namespace App\Controller;

use App\Entity\User;
use App\FormType\UserFormType;
use App\Manager\UserManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
}
