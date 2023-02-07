<?php

declare(strict_types=1);

namespace App\Country\Controller\Admin;

use App\Country\Entity\Country;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CountryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Country::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Countries');
        $crud->setSearchFields([
            'title',
            'iso2',
            'iso3',
            'phoneCode',
            'numericCode',
            'tld',
            'currency.code',
            'timezones.code',
        ]);

        return $crud;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('id')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('updatedAt')->hideOnForm()->hideOnIndex(),
            FormField::addPanel('Relations'),
            AssociationField::new('subRegion')->autocomplete(),
            AssociationField::new('currency')->autocomplete(),
            AssociationField::new('timezones')->autocomplete(),
            FormField::addPanel('Basic'),
            TextField::new('title')->setColumns(4),
            TextField::new('nativeTitle', 'Native')->setColumns(5),
            TextField::new('iso2')->setColumns(4),
            TextField::new('iso3')->setColumns(4),
            NumberField::new('numericCode', 'Numeric')->setColumns(4),
            TextField::new('phoneCode', 'Phone')->setColumns(4),
            TextField::new('flag')->setColumns(4),
            TextField::new('tld')->setColumns(4),
            FormField::addPanel('Position'),
            NumberField::new('longitude')->hideOnIndex()->setColumns(2),
            NumberField::new('latitude')->hideOnIndex()->setColumns(2),
            NumberField::new('altitude')->hideOnIndex()->setColumns(2),
        ];
    }
}
