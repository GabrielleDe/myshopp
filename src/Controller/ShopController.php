<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopController extends AbstractController
{
    #[Route('/', name: 'app_shop')]
    public function index(ProduitRepository $repo): Response
    {
        $produit=$repo->findAll();
        return $this->render('shop/index.html.twig', [
            'Produits' => $produit
        ]);
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
        ]);
    }
    #[Route('/profil/{id}', name:"app_profil")]
        public function profil(CommandeRepository $repo )
        {
            
            $commande = $repo->findAll();


            return$this->render('shop/profil.html.twig', [
                'commandes'=>$commande
            ]);
        }

    
}
