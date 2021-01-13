<?php

declare(strict_types=1);

namespace App\Utils;

use App\Entity\Argument;
use App\Entity\Campaign;
use App\Entity\Person;
use App\Entity\Politician;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Filesystem\Filesystem;

class XlsWriter implements WriterInterface
{
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function write(Campaign $campaign): ?string
    {
        $now = new \DateTimeImmutable();
        $fs = new Filesystem();

        $fs->mkdir(sprintf('%s/%s', $this->projectDir, 'public/xls-export'));

        $filename = sprintf(
            '%s/public/xls-export/%s-%s-%s.xlsx',
            $this->projectDir,
            'crowdlobbying',
            $campaign->getSlug(),
            $now->format('Y-m-d-h-i-s')
        );

        $header = [
            '#',
            'Nachname',
            'Vorname',
            'E-Mail',
            'Ort',
            'Sprache',
            'Confirmed',
            'Person created',
            'Person updated',
            'Politiker Nachname',
            'Politiker Vorname',
            'Argument',
            'CampaignEntry created',
            'CampaignEntry updated',
        ];

        $data = [];

        foreach ($campaign->getCampaignEntries() as $campaignEntry) {
            /** @var Person $person */
            $person = $campaignEntry->getPerson();

            /** @var Politician $politician */
            $politician = $campaignEntry->getPolitician();

            /** @var Argument $argument */
            $argument = $campaignEntry->getArgument();

            $data[] = [
                $campaignEntry->getId(),
                $person->getLastname(),
                $person->getFirstname(),
                $person->getEmail(),
                $person->getCity(),
                $person->getLanguage(),
                $person->isConfirmed() ? 'Ja' : 'Nein',
                $person->getCreatedAt()->format('d.m.Y H:i:s'),
                $person->getUpdatedAt()->format('d.m.Y H:i:s'),
                $politician->getLastname(),
                $politician->getName(),
                $argument->getArgument(),
                $campaignEntry->getCreatedAt()->format('d.m.Y H:i:s'),
                $campaignEntry->getUpdatedAt()->format('d.m.Y H:i:s'),
            ];
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray($header, null, 'A1');
        $sheet->fromArray($data, null, 'A2');

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        return $filename;
    }
}
