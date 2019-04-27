<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class Person
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CampaignEntry", mappedBy="person", orphanRemoval=true)
     */
    private $campaignEntries;

    public function __construct()
    {
        $this->campaignEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|CampaignEntry[]
     */
    public function getCampaignEntries(): Collection
    {
        return $this->campaignEntries;
    }

    public function addCampaignEntry(CampaignEntry $campaignEntry): self
    {
        if (!$this->campaignEntries->contains($campaignEntry)) {
            $this->campaignEntries[] = $campaignEntry;
            $campaignEntry->setPerson($this);
        }

        return $this;
    }

    public function removeCampaignEntry(CampaignEntry $campaignEntry): self
    {
        if ($this->campaignEntries->contains($campaignEntry)) {
            $this->campaignEntries->removeElement($campaignEntry);
            // set the owning side to null (unless already changed)
            if ($campaignEntry->getPerson() === $this) {
                $campaignEntry->setPerson(null);
            }
        }

        return $this;
    }
}
