<?php

declare(strict_types=1);

namespace App\Application\Controller\Admin;

use App\Application\Entity\User;
use App\Country\Entity\Country;
use App\Currency\Entity\Currency;
use App\Region\Entity\Region;
use App\SubRegion\Entity\SubRegion;
use App\Timezone\Entity\Timezone;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
            ->setTitle('GeoService');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->displayUserAvatar(false)
            ->setName($user->getUserIdentifier());
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Currencies', 'fa fa-dollar', Currency::class);
        yield MenuItem::linkToCrud('Timezones', 'fa fa-clock', Timezone::class);
        yield MenuItem::linkToCrud('Regions', 'fa fa-earth', Region::class);
        yield MenuItem::linkToCrud('Sub Regions', 'fa fa-location', SubRegion::class);
        yield MenuItem::linkToCrud('Countries', 'fa fa-flag', Country::class);
    }
}
