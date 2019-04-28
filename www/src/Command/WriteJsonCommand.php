<?php

namespace App\Command;

use App\Entity\Campaign;
use App\Entity\CampaignEntry;
use App\Entity\Politician;
use App\Utils\JsonWriter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WriteJsonCommand extends Command
{
    protected static $defaultName = 'app:write-json';

    protected $em;
    protected $jsonWriter;

    public function __construct(string $name = null, EntityManagerInterface $em, JsonWriter $jsonWriter)
    {
        $this->em = $em;
        $this->jsonWriter = $jsonWriter;

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
        foreach ($this->em->getRepository(Campaign::class)->findActiveCampaigns() as $campaign) {
            $this->jsonWriter->write($campaign, $this->em->getRepository(Politician::class), $this->em->getRepository(CampaignEntry::class));
        }
    }
}
