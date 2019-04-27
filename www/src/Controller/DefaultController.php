<?php

namespace App\Controller;

use App\Repository\CampaignRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_index", methods={"GET"})
     */
    public function index(CampaignRepository $campaignRepository)
    {

        return $this->render('default/index.html.twig', [
            'campaigns' => $campaignRepository->findActiveCampaigns(),
        ]);
    }
}
