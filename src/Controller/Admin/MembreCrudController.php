<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MembreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Membre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('pseudo'),
            TextField::new('password')->setFormType(PasswordType::class)->onlyWhenCreating(),
            TextField::new('nom'),
            TextField::new('prenom'),
            EmailField::new('email'),
            ChoiceField::new('civilite')->setChoices([
                    'Homme'=> 'Homme',
                    'Femme' => 'Femme',
                    'Autres' => 'Autres',
            ]),
            CollectionField:: new('roles')->setTemplatePath('/admin/field/roles.html.twig'),
        ];
    }

    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
     
     return ;
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $membres): void
    {
        if(!$membres->getId())
        {
            $membres->setPassword($this->hasher->hashPassword($membres, $membres->getPassword()));
            $membres->setDateEnregistrement(new \Datetime);
        }
        $entityManager->persist($membres);
        $entityManager->flush();
     return ;
    }
}
