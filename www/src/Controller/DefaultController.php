<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Repository\CampaignRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_index", methods={"GET"})
     */
    public function index(CampaignRepository $campaignRepository, Request $request)
    {
        $campaigns = $campaignRepository->findActiveCampaigns();
        if (count($campaigns) == 1) {
            /** @var Campaign $campaign */
            $campaign = array_shift($campaigns);

            return $this->redirect('https://' . $campaign->getSlug() . '.' . $request->getHost());
        }

        return $this->render('default/index.html.twig', [
            'campaigns' => $campaigns,
        ]);
    }
}
