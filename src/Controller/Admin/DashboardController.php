<?php


namespace App\Controller\Admin;


use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Skills;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{

    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        return parent::index();
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('HoYo');
    }


    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Articles');
        yield MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-tags', Category::class);

        yield MenuItem::section('Skills');
        yield MenuItem::linkToCrud('Skills', 'fas fa-code', Skills::class);

        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
    }

}
