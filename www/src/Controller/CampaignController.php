<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\CampaignEntry;
use App\Entity\Person;
use App\Entity\Politician;
use App\Form\PersonType;
use App\Repository\CampaignEntryRepository;
use App\Repository\PoliticianRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", host="{campaign}.localhost")
 */
class CampaignController extends AbstractController
{
    /**
     * @Route("/", name="app_campaign_index", methods={"GET"})
     * @MVC\ParamConverter("campaign", options={"mapping": {"campaign": "slug"}})
     */
    public function index(Campaign $campaign, PoliticianRepository $politicianRepository, CampaignEntryRepository $campaignEntryRepository): Response
    {
        $entries = $campaignEntryRepository->findBy(['campaign' => $campaign], ['id' => 'desc'], 10);
        shuffle($entries);

        return $this->render('campaign/index.html.twig', [
            'campaign' => $campaign,
            'politicians' => $politicianRepository->findByCampaign($campaign),
            'latestEntries' => $entries,
        ]);
    }

    /**
     * @Route("/lobby/{slug}", name="app_campaign_lobby", methods={"GET", "POST"})
     * @MVC\ParamConverter("campaign", options={"mapping": {"campaign": "slug"}})
     * @MVC\ParamConverter("politician", options={"mapping": {"slug": "slug"}})
     */
    public function lobby(Campaign $campaign, Politician $politician, Request $request): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            var_dump($request->request->all());
            die();
        }

        return $this->render('campaign/lobby.html.twig', [
            'campaign' => $campaign,
            'politician' => $politician,
            'form' => $form->createView(),
        ]);
    }
}
