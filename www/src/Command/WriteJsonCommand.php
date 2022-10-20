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
    private JsonWriter $jsonWriter;
    private CampaignRepository $campaignRepository;

    public function __construct(JsonWriter $jsonWriter, CampaignRepository $campaignRepository)
    {
        $this->jsonWriter = $jsonWriter;
        $this->campaignRepository = $campaignRepository;

        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this
            ->setName('app:write-json')
            ->setDescription('Dumps Current arguments to a json file for export')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->campaignRepository->findActiveCampaigns() as $campaign) {
            $this->jsonWriter->write($campaign);
        }

        return 0;
    }
}
