<?php

declare(strict_types=1);

namespace App\City\Controller\Admin;

use App\City\Entity\City;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return City::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Cities');
        $crud->setSearchFields(['title', 'country.title', 'country.iso2', 'country.iso3']);
        return $crud;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('id')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('createdAt')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('updatedAt')->hideOnForm()->hideOnIndex(),
            FormField::addFieldset('Relations'),
            AssociationField::new('country')->autocomplete(),
            AssociationField::new('state')->autocomplete()->setRequired(false),
            FormField::addFieldset('Basic'),
            TextField::new('title')->setColumns(4),
            TextField::new('iata')->setColumns(4),
            FormField::addFieldset('Position'),
            NumberField::new('longitude')->setColumns(2),
            NumberField::new('latitude')->setColumns(2),
            NumberField::new('altitude')->setColumns(2),
        ];
    }
}
