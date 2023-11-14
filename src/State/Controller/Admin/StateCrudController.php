<?php

declare(strict_types=1);

namespace App\State\Controller\Admin;

use App\State\Entity\State;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return State::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Crud::PAGE_INDEX, 'States');
        $crud->setSearchFields(['title', 'code', 'type', 'country.title', 'country.iso2', 'country.iso3']);
        return $crud;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('id')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('updatedAt')->hideOnForm()->hideOnIndex(),
            FormField::addFieldset('Relations'),
            AssociationField::new('country')->autocomplete(),
            FormField::addFieldset('Basic'),
            TextField::new('title')->setColumns(4),
            TextField::new('code')->setColumns(4),
            TextField::new('type')->setColumns(4),
            FormField::addFieldset('Position'),
            NumberField::new('longitude')->hideOnIndex()->setColumns(2),
            NumberField::new('latitude')->hideOnIndex()->setColumns(2),
            NumberField::new('altitude')->hideOnIndex()->setColumns(2),
        ];
    }
}
