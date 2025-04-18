<?php

declare(strict_types=1);

namespace App\Application\Controller\Admin;

use App\Airport\Entity\Airport;
use App\Application\Entity\User;
use App\City\Entity\City;
use App\Country\Entity\Country;
use App\Currency\Entity\Currency;
use App\Nationality\Entity\Nationality;
use App\Region\Entity\Region;
use App\State\Entity\State;
use App\SubRegion\Entity\SubRegion;
use App\Timezone\Entity\Timezone;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setFaviconPath('favicon.ico')
            ->setTitle('GeoService');
    }

    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->renderContentMaximized(true)
            ->renderSidebarMinimized(true)
            ->hideNullValues(true);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->displayUserAvatar(false)
            ->setName($user->getUserIdentifier());
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Currencies', 'fa fa-dollar', Currency::class);
        yield MenuItem::linkToCrud('Timezones', 'fa fa-clock', Timezone::class);
        yield MenuItem::linkToCrud('Regions', 'fa fa-earth', Region::class);
        yield MenuItem::linkToCrud('Sub Regions', 'fa fa-location', SubRegion::class);
        yield MenuItem::linkToCrud('Countries', 'fa fa-flag', Country::class);
        yield MenuItem::linkToCrud('Nationalities', 'fa fa-users', Nationality::class);
        yield MenuItem::linkToCrud('States', 'fa fa-arrows', State::class);
        yield MenuItem::linkToCrud('Cities', 'fa fa-building', City::class);
        yield MenuItem::linkToCrud('Airports', 'fa fa-plane', Airport::class);
    }
}
