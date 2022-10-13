<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Service\CartService;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cs): Response
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cs->getCartWithData(),
            'total' => $cs->getTotal()
        ]);
    }

    #[Route('/cart/add/{id}', name:'cart_add')]
    public function add($id,CartService $cs) // la classe request stack permet de récupérer la session 
    {
        $cs->add($id);
       
        return $this->redirectToRoute('app_cart');
    }

    #[Route("cart/remove/{id}", name:"cart_remove")]
    public function remove($id, CartService $cs)
    {
    
     $cs->remove($id);
     return $this->redirectToRoute('app_cart') ;
    }

    #[Route('/commandes', name: "app_commandes")]
    public function adminVehicule(Request $globals, CommandeRepository $repo, EntityManagerInterface $manager, CartService $cs)
    {
            $cart = $cs->getCartWithData();
            
            foreach($cart as $cartWithData):
               // dd($cartWithData['produits']);
            $commande = new Commande;
            $prix = $cartWithData['quantite']*$cartWithData['produits']->getprix();
            $commande->setProduits($cartWithData['produits']);
            $commande->setQuantite($cartWithData['quantite']);
            $commande->setMontant($prix);
            $commande->setEtat('En cours');
            $commande->setMembres($this->getUser());
            $commande->setDateEnregistrement(new \DateTime);
            $stock = $cartWithData['produits']->getStock();
            $stock -= $cartWithData['quantite'];
            $cartWithData['produits']->setStock($stock);
            $manager->persist($commande);
            $manager->flush();
            $this->addFlash('success', "La commande est validée");

            endforeach;
            return $this->redirectToRoute('app_shop');
        

       

    }
}
