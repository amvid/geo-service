<?php

declare(strict_types=1);

namespace App\State\Controller\Admin;

use App\State\Entity\State;
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

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('id')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('updatedAt')->hideOnForm()->hideOnIndex(),
            FormField::addPanel('Relations'),
            AssociationField::new('country')->autocomplete(),
            FormField::addPanel('Basic'),
            TextField::new('title')->setColumns(4),
            TextField::new('code')->setColumns(4),
            FormField::addPanel('Position'),
            NumberField::new('longitude')->hideOnIndex()->setColumns(2),
            NumberField::new('latitude')->hideOnIndex()->setColumns(2),
            NumberField::new('altitude')->hideOnIndex()->setColumns(2),
        ];
    }
}