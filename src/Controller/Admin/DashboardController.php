<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\User;
use App\Entity\Website;
use App\Repository\ClientRepository;
use App\Repository\WebsiteRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    protected $clientRepository;
    protected  $websiteRepository;

    public function __construct(ClientRepository $clientRepository, WebsiteRepository $websiteRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * @Route("admin_55fjk2f", name="admin")
     */
    public function index(): Response
    {
        $countWebsites = $this->websiteRepository->createQueryBuilder('a')
            // Filter by some parameter if you want
            // ->where('a.published = 1')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'countAllClients' => $this->clientRepository->countAllClient(),
            'countAllWebsite' => $countWebsites
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Accueil');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Clients', 'fa fa-id-badge', Client::class);
        yield MenuItem::linkToCrud('Websites', 'fa fa-grip-lines', Website::class);
    }
}
