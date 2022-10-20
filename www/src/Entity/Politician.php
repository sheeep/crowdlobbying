<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PoliticianRepository")
 * @Gedmo\SoftDeleteable()
 * @Vich\Uploadable
 */
class Politician
{
    use SoftDeleteableEntity;
    use TimestampableEntity;

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
    private $lastname;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     * @Gedmo\Slug(fields={"name", "lastname"})
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $since;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="politicians")
     */
    private $region;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PoliticianContact", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Party", inversedBy="politicians")
     * @ORM\JoinColumn(nullable=false)
     */
    private $party;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PoliticianType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $politicianType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lang;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @var SymfonyFile
     *
     * @Vich\UploadableField(mapping="politician_images", fileNameProperty="image")
     */
    private $imageFile;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commission", mappedBy="members")
     */
    private $commissions;

    public function __construct()
    {
        $this->commissions = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->name, $this->lastname);
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname($lastname): self
    {
        $this->lastname = $lastname;

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

    public function getSince(): ?\DateTimeInterface
    {
        return $this->since;
    }

    public function setSince(\DateTimeInterface $since): self
    {
        $this->since = $since;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getContact(): ?PoliticianContact
    {
        return $this->contact;
    }

    public function setContact(PoliticianContact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getParty(): ?Party
    {
        return $this->party;
    }

    public function setParty(?Party $party): self
    {
        $this->party = $party;

        return $this;
    }

    public function getPoliticianType(): ?PoliticianType
    {
        return $this->politicianType;
    }

    public function setPoliticianType(?PoliticianType $politicianType): self
    {
        $this->politicianType = $politicianType;

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function setImageFile(SymfonyFile $image = null): self
    {
        $this->imageFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    public function getImageFile(): ?SymfonyFile
    {
        return $this->imageFile;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image ?? '';

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getCommissions(): Collection
    {
        return $this->commissions;
    }

    public function setCommissions(Collection $commissions): self
    {
        $this->commissions = $commissions;

        return $this;
    }

    public function addCommission(Commission $commission): self
    {
        $this->commissions->add($commission);

        return $this;
    }

    public function removeCommission(Commission $commission): self
    {
        $this->commissions->removeElement($commission);

        return $this;
    }
}
