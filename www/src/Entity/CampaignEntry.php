<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampaignEntryRepository")
 */
class CampaignEntry
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $argument;

    /**
     * @ORM\Column(type="boolean")
     */
    private $optInInformation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="campaignEntries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campaign", inversedBy="campaignEntries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campaign;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Argument")
     */
    private $preparedArgument;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArgument(): ?string
    {
        return $this->argument;
    }

    public function setArgument(?string $argument): self
    {
        $this->argument = $argument;

        return $this;
    }

    public function getOptInInformation(): ?bool
    {
        return $this->optInInformation;
    }

    public function setOptInInformation(bool $optInInformation): self
    {
        $this->optInInformation = $optInInformation;

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

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): self
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function getPreparedArgument(): ?Argument
    {
        return $this->preparedArgument;
    }

    public function setPreparedArgument(?Argument $preparedArgument): self
    {
        $this->preparedArgument = $preparedArgument;

        return $this;
    }
}
