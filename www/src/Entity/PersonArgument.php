<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonArgumentRepository")
 */
class PersonArgument
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Gedmo\Translatable
     */
    private $argument;

    /**
     * @var Campaign
     * @ORM\ManyToOne(targetEntity="App\Entity\Campaign")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campaign;

    /**
     * @var CampaignEntry|Collection
     * @ORM\OneToMany(targetEntity="App\Entity\CampaignEntry", mappedBy="personArgument", cascade={"persist", "remove"})
     */
    private $campaignEntry;

    /**
     * @var Person
     * @ORM\ManyToOne(targetEntity="App\Entity\Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(type="string")
     */
    private $locale;

    public function __toString(): string
    {
        return $this->argument;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArgument(): ?string
    {
        return $this->argument;
    }

    public function setArgument(string $argument): self
    {
        $this->argument = $argument;

        return $this;
    }

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): self
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function getCampaignEntry()
    {
        return $this->campaignEntry;
    }

    public function setCampaignEntry(?CampaignEntry $campaignEntry): self
    {
        $this->campaignEntry = $campaignEntry;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }
}
