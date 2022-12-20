<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\SubRegion;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SubRegionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubRegion::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle('index', 'Sub Regions');
        return $crud;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('id')->hideOnForm(),
            TextField::new('title'),
            AssociationField::new('region')->autocomplete(),
            DateTimeField::new('createdAt')->hideOnForm(),
            DateTimeField::new('updatedAt')->hideOnForm(),
        ];
    }
}