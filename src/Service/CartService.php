<?php

namespace App\Service;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $repo;
    private $rs;

    public function __construct(ProduitRepository $repo, RequestStack $rs)
    {
        $this->rs = $rs;
        $this->repo = $repo;
     
     return ;
    }

    public function add($id)
    {
        $session = $this->rs->getSession();

        $cart = $session->get('cart', []);

        if(!empty($cart[$id]))
            $cart[$id]++;
        else
            $cart[$id] = 1;

        $session->set('cart',$cart);
     
     return ;
    }

    public function remove($id)
    {
        $session = $this->rs->getSession();
        $cart = $session->get('cart', []);
        
        if(!empty($cart[$id]))
            unset($cart[$id]);

        $session->set('cart', []);
    
    }

    public function getCartWithData()
    {
        $session = $this->rs->getSession();
        $cart = $session->get('cart', []);

        //nous allons créer un nouveau tableau qui conteindrat des objet de la classe Product et les quantitées de chaque objet
        $cartWithData = [];

        foreach($cart as $id => $quantite){
            $cartWithData[] = [
                'produits' => $this->repo->find($id),
                'quantite' => $quantite
            ];
        }
        return $cartWithData;
     
     return ;
    }

    public function getTotal()
    {
        $cartWithData = $this->getCartWithData();
        $total = 0;
        foreach($cartWithData as $item)
        {
            $totalUnitaire = $item['produits']->getprix() * $item['quantite'];
            $total =$total + $totalUnitaire;
        }

     
        return $total;
    }

}