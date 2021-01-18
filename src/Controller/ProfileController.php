<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ProfileController extends AbstractController
{

    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', []);
    }
}
