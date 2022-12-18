<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Timezone;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TimezoneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Timezone::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextField::new('code'),
            TextField::new('utc'),
            DateTimeField::new('createdAt')->hideOnForm(),
            DateTimeField::new('updatedAt')->hideOnForm(),
        ];
    }
}