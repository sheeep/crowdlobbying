<?php

namespace App\Controller\Admin;

use App\Entity\Argument;
use App\Entity\Campaign;
use App\Entity\CampaignEntry;
use App\Entity\Color;
use App\Entity\Commission;
use App\Entity\Party;
use App\Entity\Person;
use App\Entity\PersonArgument;
use App\Entity\Politician;
use App\Entity\PoliticianContact;
use App\Entity\PoliticianType;
use App\Entity\Region;
use App\Entity\User;
use App\Entity\WipCount;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CrowdLobbying');
    }

    public function configureCrud(): Crud
    {
        return Crud::new();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Campaign', 'fas fa-folder-open', Campaign::class);
        yield MenuItem::linkToCrud('CampaignEntry', 'fas fa-folder-open', CampaignEntry::class);
        yield MenuItem::linkToCrud('Argument', 'fas fa-folder-open', Argument::class);
        yield MenuItem::linkToCrud('WipCount', 'fas fa-folder-open', WipCount::class);
        yield MenuItem::linkToCrud('Person', 'fas fa-folder-open', Person::class);
        yield MenuItem::linkToCrud('Region', 'fas fa-folder-open', Region::class);
        yield MenuItem::linkToCrud('Party', 'fas fa-folder-open', Party::class);
        yield MenuItem::linkToCrud('PoliticianType', 'fas fa-folder-open', PoliticianType::class);
        yield MenuItem::linkToCrud('Politician', 'fas fa-folder-open', Politician::class);
        yield MenuItem::linkToCrud('PoliticianContact', 'fas fa-folder-open', PoliticianContact::class);
        yield MenuItem::linkToCrud('Commission', 'fas fa-folder-open', Commission::class);
        yield MenuItem::linkToCrud('Color', 'fas fa-folder-open', Color::class);
        yield MenuItem::linkToCrud('PersonArgument', 'fas fa-folder-open', PersonArgument::class);
        yield MenuItem::linkToCrud('User', 'fas fa-folder-open', User::class);
    }
}
