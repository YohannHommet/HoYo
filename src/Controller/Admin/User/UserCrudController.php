<?php


namespace App\Controller\Admin\User;


use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class UserCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('firstname', 'Firstname'),
            TextField::new('lastname', 'Lastname'),
            EmailField::new('email', 'Email'),
            ArrayField::new('roles'),
            BooleanField::new('isVerified'),
            TextField::new('password', 'Password')->setRequired(false)->hideOnDetail(),
        ];
    }

}
