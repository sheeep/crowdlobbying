<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Campaign;
use App\Entity\CampaignEntry;
use App\Entity\Color;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    private array $colors = [
        '#e33935',
        '#d71a60',
        '#8e24aa',
        '#5e34b1',
        '#3949aa',
        '#1d88e5',
        '#039be5',
        '#00acc0',
        '#01887b',
        '#43a047',
        '#e24b26',
    ];

    public function getFilters(): array
    {
        return [
            new TwigFilter('color', [$this, 'getColor'], [
                'needs_context' => true,
            ]),
        ];
    }

    public function getColor($context): string
    {
        $campaign = $context['campaign'] ?? null;
        $campaignEntry = $context['entry'] ?? $context['campaignEntry'] ?? null;
        $colors = null;

        if (null === $campaignEntry && null === $campaign) {
            return $this->colors[array_rand($this->colors)];
        }

        if ($campaignEntry instanceof CampaignEntry) {
            $colors = $campaignEntry->getCampaign()->getColors();
        }

        if ($campaign instanceof Campaign) {
            $colors = $campaign->getColors();
        }

        if (null === $colors || !$colors->count()) {
            return $this->colors[array_rand($this->colors)];
        }

        $colors = $colors->toArray();
        $color = $colors[array_rand($colors)];

        if (!$color instanceof Color) {
            return $campaignEntry->getColor();
        }

        return $color->getColor();
    }
}
