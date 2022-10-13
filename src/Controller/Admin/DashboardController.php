<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use App\Entity\Produit;
use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route ('/admin', name:'app_admin')]
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<p> BackOffice Myshopp</p>');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Shopp');
        yield MenuItem::linkToCrud('Produits', 'fas fa-newspaper', Produit::class);
        yield MenuItem::section('Membres');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', Membre::class);
        yield MenuItem::section('Gestion');
        yield MenuItem::linkToCrud('Commande', 'fas fa-newspaper', Commande::class);

    }
}
