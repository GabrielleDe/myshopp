<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titre', 'Titre'),
            TextEditorField::new('description'),
            TextField::new('couleur'),
            ChoiceField::new('taille')->setChoices(['S'=> 'Small',
            'M'=>'Medium',
            'L'=>'Large',
            'XL'=>'Très Large'

            ]),
            ChoiceField::new('collection')->setChoices(['H'=>'Homme', 'F'=>'Femme', 'E'=>'Enfants']),
            TextField::new('photo'),
            MoneyField::new('prix')->setCurrency('EUR'),
            IntegerField::new('stock'),
            
        ];
    }
    
    public function createEntity(string $entityFqcn)
    {
      $produit = new $entityFqcn;
      $produit->setDateEnregistrement(new \Datetime);
     
     return $produit;
    }
}
