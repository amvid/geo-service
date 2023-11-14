<?php

declare(strict_types=1);

namespace App\Airport\Controller\Admin;

use App\Airport\Entity\Airport;
use App\Country\Controller\Admin\CountryCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AirportCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Airport::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Airports');
        $crud->setSearchFields(['iata', 'icao', 'title']);
        return $crud;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('id')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('updatedAt')->hideOnForm()->hideOnIndex(),
            FormField::addFieldset('Relations'),
            AssociationField::new('timezone')->autocomplete(),
            AssociationField::new('city.country')
                ->setLabel('Country')
                ->hideOnForm()
                ->setCrudController(CountryCrudController::class),
            AssociationField::new('city')->autocomplete(),
            FormField::addFieldset('Basic'),
            TextField::new('title')->setColumns(4),
            TextField::new('iata')->setColumns(4),
            TextField::new('icao')->setColumns(4),
            FormField::addFieldset('Position'),
            NumberField::new('longitude')->hideOnIndex()->setColumns(2),
            NumberField::new('latitude')->hideOnIndex()->setColumns(2),
            NumberField::new('altitude')->hideOnIndex()->setColumns(2),
        ];
    }
}
