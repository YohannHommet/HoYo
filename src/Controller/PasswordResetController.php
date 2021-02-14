<?php

namespace App\Controller;


use App\Form\PasswordResetFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;


/**
 * @Route("/profile")
 * @package App\Controller
 */
class PasswordResetController extends AbstractController
{

    /**
     * @Route("/password-reset", name="app_password_reset", methods={"GET|POST"})
     * @param \Symfony\Component\HttpFoundation\Request                             $request
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $encoder
     * @param \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface            $tokenManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder, CsrfTokenManagerInterface $tokenManager): Response
    {
        /** @var \App\Entity\User|$user */
        $user = $this->getUser();

        if (!$user->isVerified()) {
            $this->addFlash('danger', 'Please verify your account first');
            return $this->redirectToRoute('app_profile');
        }

        $form = $this->createForm(PasswordResetFormType::class, $user);
        $form->handleRequest($request);

        $token = new CsrfToken('reset_password', $request->request->get('_csrf_token'));

        // Check if old_password is the current password of the User
        if ($form->isSubmitted() && $form->isValid() && $encoder->isPasswordValid($user, $form['old_password']->getData()) && $tokenManager->isTokenValid($token)) {
            $user->setPassword($encoder->encodePassword($user, $form['new_password']->getData()));
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Password have been updated.');
            return $this->redirectToRoute('app_profile');
        }


        return $this->render('profile/password_reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
