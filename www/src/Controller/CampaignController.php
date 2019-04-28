<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\CampaignEntry;
use App\Entity\Person;
use App\Entity\Politician;
use App\Form\PersonType;
use App\Repository\ArgumentRepository;
use App\Repository\CampaignEntryRepository;
use App\Repository\PoliticianRepository;
use App\Utils\JsonWriter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", host="{campaign}.localhost", requirements={"campaign"="[\w-]+"})
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
     * @Route("/lobby/{slug}", name="app_campaign_lobby", methods={"GET", "POST"}, requirements={"slug"="[\w\.-]+"})
     * @MVC\ParamConverter("campaign", options={"mapping": {"campaign": "slug"}})
     * @MVC\ParamConverter("politician", options={"mapping": {"slug": "slug"}})
     */
    public function lobby(Campaign $campaign, Politician $politician, ArgumentRepository $argumentRepository, JsonWriter $jsonWriter, \Swift_Mailer $mailer, Request $request): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $argument = $argumentRepository->findOneBy(['campaign' => $campaign, 'id' => $request->request->get('argument', 0)]);
            if ($argument) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($person);

                $campaignEntry = new CampaignEntry();
                $campaignEntry->setOptInInformation((bool) ($request->request->get('optInInformation', 0)));
                $campaignEntry->setPerson($person);
                $campaignEntry->setCampaign($campaign);
                $campaignEntry->setArgument($argument);
                $campaignEntry->setPolitician($politician);
                $campaignEntry->setColor($campaignEntry->getRandomColor());

                $em->persist($campaignEntry);
                $em->flush();

                $jsonWriter->write($campaign);
                // @TODO call PDF generator
                $message = (new \Swift_Message('Crowd-Lobbying: Keinen digitalen Pass von privaten Unternehmen!'))
                    ->setFrom('send@example.com')
                    ->setTo($person->getEmail())
                    ->setBody(
                        $this->renderView(
                            'emails/confirmation.txt.twig',
                            [
                                'person' => $person,
                                'politician' => $politician,
                            ]
                        ),
                        'text/plain'
                    );
                $mailer->send($message);
                return $this->redirectToRoute('app_campaign_thanks', ['campaign' => $campaign->getSlug(), 'id' => $campaignEntry->getId()]);
            }
        }

        return $this->render('campaign/lobby.html.twig', [
            'campaign' => $campaign,
            'politician' => $politician,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/thanks/{id}", name="app_campaign_thanks", methods={"GET"}, requirements={"id"="\d+"})
     * @MVC\ParamConverter("campaign", options={"mapping": {"campaign": "slug"}})
     */
    public function thanks(Campaign $campaign, CampaignEntry $campaignEntry): Response
    {
        return $this->render('campaign/thanks.html.twig', [
            'campaign' => $campaign,
            'campaignEntry' => $campaignEntry,
        ]);
    }

    /**
     * @Route("/statements", name="app_campaign_statements", methods={"GET"}, defaults={"id"="0"})
     * @Route("/statement/{id}", name="app_campaign_statement", methods={"GET"}, requirements={"id"="\d+"})
     * @MVC\ParamConverter("campaign", options={"mapping": {"campaign": "slug"}})
     */
    public function statements(Campaign $campaign, CampaignEntry $campaignEntry = null): Response
    {
        return $this->render('campaign/statements.html.twig', [
            'campaign' => $campaign,
            'campaignEntry' => $campaignEntry,
        ]);
    }
}
