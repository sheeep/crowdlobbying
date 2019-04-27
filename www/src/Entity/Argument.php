<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArgumentRepository")
 */
class Argument
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    use TimestampableEntity;

    /**
     * @ORM\Column(type="text")
     */
    private $argument;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campaign", inversedBy="arguments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campaign;

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
}
