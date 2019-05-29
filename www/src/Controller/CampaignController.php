<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\CampaignEntry;
use App\Entity\Person;
use App\Entity\Politician;
use App\Entity\Region;
use App\Form\PersonType;
use App\Repository\ArgumentRepository;
use App\Repository\CampaignEntryRepository;
use App\Repository\PersonRepository;
use App\Repository\PoliticianRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}", host="{campaign}.localhost", requirements={"campaign"="[\w-]+", "_locale"="de|fr|"})
 */
class CampaignController extends AbstractController
{
    /**
     * @Route("/", name="app_campaign_index", methods={"GET"}, requirements={"region"="\d+"})
     * @MVC\ParamConverter("campaign", options={"mapping": {"campaign": "slug"}})
     */
    public function index(Campaign $campaign, PoliticianRepository $politicianRepository, CampaignEntryRepository $campaignEntryRepository, Request $request): Response
    {
        if ($request->getMethod() == 'GET' && $request->getLocale() != $request->get('_locale')) {
            return $this->redirectToRoute('app_campaign_index', ['campaign' => $campaign->getSlug(), '_locale' => $request->getLocale()]);
        }

        $entries = $campaignEntryRepository->findBy(['campaign' => $campaign], ['id' => 'desc'], 10);
        shuffle($entries);

        return $this->render('campaign/index.html.twig', [
            'campaign' => $campaign,
            'politicians' => $politicianRepository->findByCampaign($campaign),
            'latestEntries' => $entries,
            'total' => count($campaignEntryRepository->findBy(['campaign' => $campaign])),
        ]);
    }

    /**
     * @Route("/{region}", name="app_campaign_region_redirect", methods={"GET"}, requirements={"region"="\d+"})
     * @MVC\ParamConverter("campaign", options={"mapping": {"campaign": "slug"}})
     * @MVC\ParamConverter("region", options={"mapping": {"region": "id"}})
     */
    public function regionRedirect(Campaign $campaign, Region $region = null, Request $request): RedirectResponse
    {
        if ($request->getMethod() == 'GET' && $request->getLocale() != $request->get('_locale')) {
            return $this->redirectToRoute('app_campaign_region_redirect', ['campaign' => $campaign->getSlug(), 'region' => $region->getId(), '_locale' => $request->getLocale()]);
        }

        return $this->redirectToRoute('app_campaign_region', ['campaign' => $campaign->getSlug(), 'region' => $region->getSlug(), '_locale' => $request->getLocale()]);
    }

    /**
     * @Route("/{region}", name="app_campaign_region", methods={"GET"}, requirements={"region"="[\w]{2}"})
     * @MVC\ParamConverter("campaign", options={"mapping": {"campaign": "slug"}})
     * @MVC\ParamConverter("region", options={"mapping": {"region": "slug"}})
     */
    public function region(Campaign $campaign, Region $region = null, Request $request, PoliticianRepository $politicianRepository, CampaignEntryRepository $campaignEntryRepository): Response
    {
        if ($request->getMethod() == 'GET' && $request->getLocale() != $request->get('_locale')) {
            return $this->redirectToRoute('app_campaign_region', ['campaign' => $campaign->getSlug(), 'region' => $region->getSlug(), '_locale' => $request->getLocale()]);
        }

        $entries = $campaignEntryRepository->findBy(['campaign' => $campaign], ['id' => 'desc'], 10);
        shuffle($entries);

        return $this->render('campaign/index.html.twig', [
            'campaign' => $campaign,
            'politicians' => $politicianRepository->findByTypeAndRegions($campaign->getPoliticianType(), [$region]),
            'latestEntries' => $entries,
            'total' => count($campaignEntryRepository->findBy(['campaign' => $campaign])),
            'region' => $region,
        ]);
    }

    /**
     * @Route("/lobby/{slug}", name="app_campaign_lobby", methods={"GET", "POST"}, requirements={"slug"="[\w\.-]+"})
     * @MVC\ParamConverter("campaign", options={"mapping": {"campaign": "slug"}})
     * @MVC\ParamConverter("politician", options={"mapping": {"slug": "slug"}})
     */
    public function lobby(Campaign $campaign, Politician $politician, ArgumentRepository $argumentRepository, PersonRepository $personRepository, \Swift_Mailer $mailer, Request $request): Response
    {
        if ($request->getMethod() == 'GET' && $request->getLocale() != $request->get('_locale')) {
            return $this->redirectToRoute('app_campaign_lobby', ['campaign' => $campaign->getSlug(), 'slug' => $politician->getSlug(), '_locale' => $request->getLocale()]);
        }

        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('person', $request->request->get('token'))) {
            $argument = $argumentRepository->findOneBy(['campaign' => $campaign, 'id' => $request->request->get('argument', 0)]);
            if ($argument) {
                $em = $this->getDoctrine()->getManager();
                $testPerson = $personRepository->findOneBy(['email' => $person->getEmail()]);
                if ($testPerson) {
                    // update person if something has changed
                    // doctrine will take care of the changeset...
                    $testPerson->setFirstname($person->getFirstname());
                    $testPerson->setLastname($person->getLastname());
                    $testPerson->setCity($person->getCity());
                    $person = $testPerson;
                } else {
                    $em->persist($person);
                }

                $person->setLanguage($request->getLocale());
                $campaignEntry = new CampaignEntry();
                $campaignEntry->setOptInInformation((bool) ($request->request->get('optInInformation', 0)));
                $campaignEntry->setPerson($person);
                $campaignEntry->setCampaign($campaign);
                $campaignEntry->setArgument($argument);
                $campaignEntry->setPolitician($politician);
                $campaignEntry->setColor($campaignEntry->getRandomColor());

                $em->persist($campaignEntry);
                $em->flush();

                //$jsonWriter->write($campaign);

                // @TODO call PDF generator
                $message = (new \Swift_Message('Crowd-Lobbying'))
                    ->setFrom('lobbying@publicbeta.ch')
                    ->setTo($person->getEmail())
                    ->setBody(
                        $this->renderView(
                            'emails/confirmation.html.twig',
                            [
                                'person' => $person,
                                'politician' => $politician,
                            ]
                        ),
                        'text/html'
                    );

                $mailer->send($message);
                return $this->redirectToRoute('app_campaign_thanks', ['campaign' => $campaign->getSlug(), 'id' => $campaignEntry->getId()]);
            }
        }

        return $this->render('campaign/lobby.html.twig', [
            'campaign' => $campaign,
            'politician' => $politician,
            'form' => $form->createView(),
            'person' => $person,
        ]);
    }

    /**
     * @Route("/thanks/{id}", name="app_campaign_thanks", methods={"GET"}, requirements={"id"="\d+"})
     * @MVC\ParamConverter("campaign", options={"mapping": {"campaign": "slug"}})
     */
    public function thanks(Campaign $campaign, CampaignEntry $campaignEntry, Request $request): Response
    {
        if ($request->getMethod() == 'GET' && $request->getLocale() != $request->get('_locale')) {
            return $this->redirectToRoute('app_campaign_thanks', ['campaign' => $campaign->getSlug(), 'id' => $campaignEntry->getId(), '_locale' => $request->getLocale()]);
        }

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
    public function statements(Campaign $campaign, Request $request, CampaignEntry $campaignEntry = null): Response
    {
        if ($request->getMethod() == 'GET' && $request->getLocale() != $request->get('_locale')) {
            if ($request->query->get('id', 0) > 0) {
                return $this->redirectToRoute('app_campaign_statement', ['campaign' => $campaign->getSlug(), 'id' => $request->query->get('id'), '_locale' => $request->getLocale()]);
            }
            return $this->redirectToRoute('app_campaign_statements', ['campaign' => $campaign->getSlug(), '_locale' => $request->getLocale()]);
        }

        return $this->render('campaign/statements.html.twig', [
            'campaign' => $campaign,
            'campaignEntry' => $campaignEntry,
        ]);
    }
}
