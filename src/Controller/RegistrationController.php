<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;


class RegistrationController extends AbstractController
{

    private EmailVerifier $emailVerifier;


    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }


    /**
     * @Route("/register", name="app_register")
     * @param \Symfony\Component\HttpFoundation\Request                             $request
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $encoder
     * @param \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface            $tokenManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, CsrfTokenManagerInterface $tokenManager): Response
    {
        if ($this->getUser()) {
            $this->addFlash('warning', 'Cannot register, please log out first');
            return $this->redirectToRoute('app_home');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $token = new CsrfToken('register', $request->request->get('_csrf_token'));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $tokenManager->isTokenValid($token)) {
            // encode the password
            $user->setPassword($encoder->encodePassword($user, $form['password']->getData()));

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            // generate a signed url and email it to the user
            //            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            //                (new TemplatedEmail())
            //                    ->from(new Address('no-reply@hoyo.com', "Hoyo Mail Bot"))
            //                    ->to($user->getEmail())
            //                    ->subject('Please Confirm your Email')
            //                    ->htmlTemplate('registration/confirmation_email.html.twig')
            //            );

            $this->addFlash('success', "Registration complete ! A confirmation link has been send to your email address");
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    /**
     * @Route("/verify-email", name="app_verify_email")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Your email address has been verified, thank you traveller !');

        return $this->redirectToRoute('app_register');
    }

}
