<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Repository\CampaignEntryRepository;
use App\Repository\PoliticianRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
