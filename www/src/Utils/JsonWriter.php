<?php

declare(strict_types=1);

namespace App\Utils;

use App\Entity\Campaign;
use App\Repository\CampaignEntryRepository;
use App\Repository\PoliticianRepository;
use Symfony\Component\Filesystem\Filesystem;

class JsonWriter implements WriterInterface
{
    protected $projectDir;
    protected $politicianRepository;
    protected $campaignEntryRepository;

    public function __construct(string $projectDir, PoliticianRepository $politicianRepository, CampaignEntryRepository $campaignEntryRepository)
    {
        $this->projectDir = $projectDir;
        $this->politicianRepository = $politicianRepository;
        $this->campaignEntryRepository = $campaignEntryRepository;
    }

    public function write(Campaign $campaign): ?string
    {
        $data = ['date' => date('Y-m-d H:i:s'), 'campaign' => $campaign->getName(), 'politicians' => []];
        foreach ($this->politicianRepository->findByCampaign($campaign) as $politician) {
            $contact = $politician->getContact();
            $entry = [
                'salutation' => $contact->getSalutation() ?: '',
                'name' => $contact->getPrename() ?: '',
                'surname' => $contact->getLastname() ?: '',
                'postSalutation' => $contact->getPostSalutation() ?: '',
                'address' => implode('<br>', $contact->getAddressArray()),
                'zip' => $contact->getZip() ?: '',
                'city' => $contact->getCity() ?: '',
                'email' => $contact->getEmail() ?: '',
                'mobile' => $contact->getMobile() ?: '',
                'phone' => $contact->getPhone() ?: '',
                'fax' => $contact->getFax() ?: '',
                'website' => $contact->getWebsite() ?: '',
                'id' => $politician->getId(),
                'messages' => [],
            ];
            foreach ($campaign->getArguments() as $argument) {
                $message = ['text' => $argument->getArgument(), 'senders' => []];
                foreach ($this->campaignEntryRepository->findBy(['campaign' => $campaign, 'politician' => $politician, 'argument' => $argument], ['id' => 'ASC']) as $campaignEntry) {
                    $person = $campaignEntry->getPerson();
                    $message['senders'][] = [
                        'name' => $person->getFirstname() . ' ' . $person->getLastname(),
                        'location' => $person->getCity(),
                    ];
                }

                $entry['messages'][] = $message;
            }

            $data['politicians'][] = $entry;
        }

        $fileSystem = new Filesystem();
        $fileSystem->dumpFile($this->projectDir . '/../data/messages.json', json_encode($data));

        return null;
    }
}
