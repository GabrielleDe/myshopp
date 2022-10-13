<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('membres')->renderAsNativeWidget(),
            AssociationField::new('produits')->renderAsNativeWidget(),
            IntegerField::new('quantite'),
            MoneyField::new('montant')->setCurrency('EUR'),
            TextField::new('etat'),
            
            
        ];
    }

    public function createEntity(string $entityFqcn)
    {
      $commande = new $entityFqcn;
      $commande->setDateEnregistrement(new \Datetime);
     
     return $commande;
    }
    
}
