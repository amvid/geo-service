<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Country;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CountryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Country::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('id')->hideOnForm(),
            AssociationField::new('subRegion')->autocomplete(),
            AssociationField::new('currency')->autocomplete(),
            AssociationField::new('timezones')->autocomplete(),
            TextField::new('title'),
            TextField::new('nativeTitle'),
            TextField::new('iso2'),
            TextField::new('iso3'),
            NumberField::new('numericCode'),
            TextField::new('phoneCode'),
            TextField::new('flag'),
            TextField::new('tld'),
            NumberField::new('longitude'),
            NumberField::new('latitude'),
            NumberField::new('altitude'),
            DateTimeField::new('createdAt')->hideOnForm(),
            DateTimeField::new('updatedAt')->hideOnForm(),
        ];
    }
}