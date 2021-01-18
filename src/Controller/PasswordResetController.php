<?php

namespace App\Controller;


use App\Form\PasswordResetFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/profile")
 * @package App\Controller
 */
class PasswordResetController extends AbstractController
{

    /**
     * @Route("/password-reset", name="app_password_reset", methods={"GET|POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request                             $request
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        /** @var \App\Entity\User|$user */
        $user = $this->getUser();
        $form = $this->createForm(PasswordResetFormType::class, $user);
        $form->handleRequest($request);

        // Check if old_password is the current password of the User
        if ($form->isSubmitted() && $form->isValid() && $encoder->isPasswordValid($user, $form['old_password']->getData())) {
            $user->setPassword($encoder->encodePassword($user, $form['new_password']->getData()));
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Password have been updated');
            return $this->redirectToRoute('app_profile');
        }


        return $this->render('profile/password_reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
