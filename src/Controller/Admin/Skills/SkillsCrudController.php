<?php


namespace App\Controller\Admin\Skills;


use App\Entity\Skills;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class SkillsCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Skills::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setFormTypeOptions(['disabled' => true]),
            TextField::new('name'),
            ImageField::new('image')
                ->setBasePath('uploads')
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
        ];
    }

}
