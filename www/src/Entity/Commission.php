<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommissionRepository")
 */
class Commission
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $abbreviation;

    /**
     * @var PoliticianType
     * @ORM\OneToOne(targetEntity="App\Entity\PoliticianType")
     * @ORM\JoinColumn(name="politician_type_id", referencedColumnName="id")
     */
    private $politicianType;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Politician")
     * @ORM\JoinTable(name="commissions_politicians",
     *     joinColumns={@ORM\JoinColumn(name="commission_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="politician_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    public function getPoliticianType(): ?PoliticianType
    {
        return $this->politicianType;
    }

    public function setPoliticianType(PoliticianType $politicianType): self
    {
        $this->politicianType = $politicianType;

        return $this;
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Politician $member): self
    {
        $this->members->add($member);

        return $this;
    }

    public function removeMember(Politician $member): self
    {
        $this->members->removeElement($member);

        return $this;
    }

    public function setMembers(Collection $members): self
    {
        $this->members = $members;

        return $this;
    }
}
