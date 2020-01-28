<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\CampaignRepository;
use App\Utils\JsonWriter;
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

    protected function configure(): void
    {
        $this
            ->setDescription('Dumps Current arguments to a json file for export')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        foreach ($this->campaignRepository->findActiveCampaigns() as $campaign) {
            $this->jsonWriter->write($campaign);
        }
    }
}
