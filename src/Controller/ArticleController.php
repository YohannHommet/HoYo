<?php


namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{

    private EntityManagerInterface $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/fakeblog", name="app_blog")
     */
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $this->em->getRepository(Article::class)->findBy([], ['createdAt' => 'DESC'],)
        ]);
    }


    /**
     * @Route("/fakeblog/{slug}", name="app_blog_show")
     * @param \App\Entity\Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'a' => $article
        ]);
    }

}
