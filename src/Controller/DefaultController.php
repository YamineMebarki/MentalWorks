<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\WebsiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class DefaultController extends AbstractController
{
    private $websiteRepository;
    private $clientRepository;

    public function __construct(WebsiteRepository $websiteRepository, ClientRepository $clientRepository)
    {
        $this->websiteRepository = $websiteRepository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $countWebsites = $this->websiteRepository->createQueryBuilder('a')
            // Filter by some parameter if you want
            // ->where('a.published = 1')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $count = null;
        if($request->request->count() > 0 && $request->request->get('submitSearch') == 'Search'){
            $websites = $this->websiteRepository->findBy([
                'name' => $request->request->get('search')
            ]);
            if ($websites == [])
            {
                $websiteAuthor = $this->clientRepository->findBy([
                    'name' => $request->request->get('search')
                ]);
                if ($websiteAuthor != []){
                    $websites = $this->websiteRepository->findBy([
                        'client' => $websiteAuthor
                    ]);
                }
            }
            $count = 1;
        }else {
            $allAppointmentsQuery = $this->websiteRepository->createQueryBuilder('p')
                ->select('p')
                ->orderBy('p.id', 'DESC')
                ->getQuery();
            $websites = $paginator->paginate(
            // Doctrine Query, not results
                $allAppointmentsQuery,
                // Define the page parameter
                $request->query->getInt('page', 1),
                // Items per page
                15
            );
        }
        return $this->render('default/index.html.twig', [
            'websites' => $websites,
            'count' => $count,
            'countWebsite' => $countWebsites
        ]);
    }

    /**
     * @Route("/change_locale/{locale}", name="change_locale")
     */
    public function changeLocale($locale, Request $request)
    {
        // On stocke la langue dans la session
        $request->getSession()->set('_locale', $locale);

        // On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }

}
