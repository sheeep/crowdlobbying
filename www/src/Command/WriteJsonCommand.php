<?php

namespace App\Command;

use App\Entity\Campaign;
use App\Entity\CampaignEntry;
use App\Entity\Politician;
use App\Repository\CampaignRepository;
use App\Utils\JsonWriter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WriteJsonCommand extends Command
{
    protected static $defaultName = 'app:write-json';

    protected $jsonWriter;
    protected $campaignRepository;

    public function __construct(string $name = null, JsonWriter $jsonWriter, CampaignRepository $campaignRepository)
    {
        $this->jsonWriter = $jsonWriter;
        $this->campaignRepository = $campaignRepository;

        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this
            ->setDescription('Dumps Current arguments to a json file for export')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->campaignRepository->findActiveCampaigns() as $campaign) {
            $this->jsonWriter->write($campaign);
        }
    }
}
