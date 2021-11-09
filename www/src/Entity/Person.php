<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class Person
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern     = "/^[^@]+$/i",
     *     htmlPattern = "^[^@]+$"
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern     = "/^[^@]+$/i",
     *     htmlPattern = "^[^@]+$"
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CampaignEntry", mappedBy="person", orphanRemoval=true)
     */
    private $campaignEntries;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern     = "/^[^0-9]+$/i",
     *     htmlPattern = "^[^0-9]+$"
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $language;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $confirmed = false;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $confirmationToken;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $confirmationExpires;

    public function __construct()
    {
        $this->campaignEntries = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    public function getConfirmationExpires(): ?\DateTime
    {
        return $this->confirmationExpires;
    }

    public function setConfirmationExpires(?\DateTime $confirmationExpires): self
    {
        $this->confirmationExpires = $confirmationExpires;

        return $this;
    }
}
