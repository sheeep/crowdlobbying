<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartyRepository")
 */
class Party implements Translatable
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
     * @Gedmo\Translatable
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Politician", mappedBy="party")
     */
    private $politicians;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\File", cascade={"persist", "remove"})
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Translatable
     */
    private $short;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    public function __construct()
    {
        $this->politicians = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getName();
    }

    public function setTranslatableLocale($locale): void
    {
        $this->locale = $locale;
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

    /**
     * @return Collection|Politician[]
     */
    public function getPoliticians(): Collection
    {
        return $this->politicians;
    }

    public function addPolitician(Politician $politician): self
    {
        if (!$this->politicians->contains($politician)) {
            $this->politicians[] = $politician;
            $politician->setParty($this);
        }

        return $this;
    }

    public function removePolitician(Politician $politician): self
    {
        if ($this->politicians->contains($politician)) {
            $this->politicians->removeElement($politician);
            // set the owning side to null (unless already changed)
            if ($politician->getParty() === $this) {
                $politician->setParty(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?File
    {
        return $this->logo;
    }

    public function setLogo(?File $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getShort(): ?string
    {
        return $this->short;
    }

    public function setShort(string $short): self
    {
        $this->short = $short;

        return $this;
    }
}
