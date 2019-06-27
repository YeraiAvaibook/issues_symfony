<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Managers\UserManager;
use App\Repository\UserRepository;
use App\Services\ValidatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder, ValidatorService $validatorService, UserManager $userManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $error_message = '';

        if ($form->isSubmitted() && $form->isValid()) {

            // Validamos DNI
            $validacion_dni = $validatorService->validarDNI($user->getDni());

            if ($validacion_dni['estado']) {

                $passEncrypted = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($passEncrypted);

                $userManager->create($user);

                return $this->redirectToRoute('user_index');

            } else {
                $error_message = $this->addFlash('danger', $validacion_dni['texto']);
            }

        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'error' => $error_message
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, ValidatorService $validatorService, UserManager $userManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $error_message = '';

        if ($form->isSubmitted() && $form->isValid()) {

            // Validamos DNI
            $validacion_dni = $validatorService->validarDNI($user->getDni());

            if ($validacion_dni['estado']) {

                $userManager->update($user);

                return $this->redirectToRoute('user_index', [
                    'id' => $user->getId(),
                ]);
            }else
                $error_message = $this->addFlash('danger', $validacion_dni['texto']);

        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'error' => $error_message
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user, UserManager $userManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userManager->delete($user);
        }

        return $this->redirectToRoute('user_index');
    }
}
