<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampaignRepository")
 */
class Campaign
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CampaignEntry", mappedBy="campaign", orphanRemoval=true)
     */
    private $campaignEntries;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Argument", mappedBy="campaign", orphanRemoval=true)
     */
    private $arguments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Region")
     */
    private $regions;

    /**
     * @ORM\Column(type="integer")
     */
    private $politicianType;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WipCount", mappedBy="campaign", orphanRemoval=true)
     */
    private $wipCounts;

    public function __construct()
    {
        $this->campaignEntries = new ArrayCollection();
        $this->arguments = new ArrayCollection();
        $this->regions = new ArrayCollection();
        $this->wipCounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

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
            $campaignEntry->setCampaign($this);
        }

        return $this;
    }

    public function removeCampaignEntry(CampaignEntry $campaignEntry): self
    {
        if ($this->campaignEntries->contains($campaignEntry)) {
            $this->campaignEntries->removeElement($campaignEntry);
            // set the owning side to null (unless already changed)
            if ($campaignEntry->getCampaign() === $this) {
                $campaignEntry->setCampaign(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Argument[]
     */
    public function getArguments(): Collection
    {
        return $this->arguments;
    }

    public function addArgument(Argument $argument): self
    {
        if (!$this->arguments->contains($argument)) {
            $this->arguments[] = $argument;
            $argument->setCampaign($this);
        }

        return $this;
    }

    public function removeArgument(Argument $argument): self
    {
        if ($this->arguments->contains($argument)) {
            $this->arguments->removeElement($argument);
            // set the owning side to null (unless already changed)
            if ($argument->getCampaign() === $this) {
                $argument->setCampaign(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Region[]
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Region $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions[] = $region;
        }

        return $this;
    }

    public function removeRegion(Region $region): self
    {
        if ($this->regions->contains($region)) {
            $this->regions->removeElement($region);
        }

        return $this;
    }

    public function getPoliticianType(): ?int
    {
        return $this->politicianType;
    }

    public function setPoliticianType(int $politicianType): self
    {
        $this->politicianType = $politicianType;

        return $this;
    }

    /**
     * @return Collection|WipCount[]
     */
    public function getWipCounts(): Collection
    {
        return $this->wipCounts;
    }

    public function addWipCount(WipCount $wipCount): self
    {
        if (!$this->wipCounts->contains($wipCount)) {
            $this->wipCounts[] = $wipCount;
            $wipCount->setCampaign($this);
        }

        return $this;
    }

    public function removeWipCount(WipCount $wipCount): self
    {
        if ($this->wipCounts->contains($wipCount)) {
            $this->wipCounts->removeElement($wipCount);
            // set the owning side to null (unless already changed)
            if ($wipCount->getCampaign() === $this) {
                $wipCount->setCampaign(null);
            }
        }

        return $this;
    }
}
