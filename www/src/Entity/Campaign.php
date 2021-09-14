<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampaignRepository")
 * @Vich\Uploadable
 */
class Campaign
{
    use TimestampableEntity;

    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, unique=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CampaignEntry", mappedBy="campaign", orphanRemoval=true)
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $campaignEntries;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Argument", mappedBy="campaign", orphanRemoval=true)
     * @ORM\OrderBy({"argument" = "ASC"})
     */
    private $arguments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Region")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $regions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WipCount", mappedBy="campaign", orphanRemoval=true)
     */
    private $wipCounts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="campaign", orphanRemoval=true)
     */
    private $pages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PoliticianType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $politicianType;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commission")
     * @ORM\JoinTable(name="campaigns_commissions",
     *      joinColumns={@ORM\JoinColumn(name="campaign_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="commission_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $commissions;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Translatable
     */
    private $campaignTitle;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Translatable
     */
    private $campaignDescription;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Translatable
     */
    private $ogCampaignDescription;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $ogImageDe;

    /**
     * @var SymfonyFile
     * @Vich\UploadableField(mapping="campaign_images", fileNameProperty="ogImageDe")
     */
    private $ogImageFileDe;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $ogImageFr;

    /**
     * @var SymfonyFile
     * @Vich\UploadableField(mapping="campaign_images", fileNameProperty="ogImageFr")
     */
    private $ogImageFileFr;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Translatable
     */
    private $hero;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Translatable
     */
    private $total;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Translatable
     */
    private $campaignInfoLead;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Translatable
     */
    private $campaignInfo;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Translatable
     */
    private $howItWorksStep1;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Translatable
     */
    private $howItWorksStep2;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Translatable
     */
    private $howItWorksStep3;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Translatable
     */
    private $howItWorksFinish;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Translatable
     */
    private $donorBox;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Translatable()
     */
    private $shareTextBox;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Translatable
     */
    private $faqTitle;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Translatable()
     */
    private $faqText;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $heroBackground;

    /**
     * @var SymfonyFile
     * @Vich\UploadableField(mapping="campaign_images", fileNameProperty="heroBackground")
     */
    private $heroBackgroundFile;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $mailThanksText;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $doubleOptIn = false;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Translatable
     */
    private $heroSubline;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Color")
     * @ORM\JoinTable(name="campaigns_colors",
     *     joinColumns={@ORM\JoinColumn(name="campaign_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="color_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $colors;

    public function __construct()
    {
        $this->campaignEntries = new ArrayCollection();
        $this->arguments = new ArrayCollection();
        $this->regions = new ArrayCollection();
        $this->wipCounts = new ArrayCollection();
        $this->pages = new ArrayCollection();
        $this->commissions = new ArrayCollection();
        $this->colors = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function setTranslatableLocale($locale): void
    {
        $this->locale = $locale;
    }

    public function getWipCountByPolitician(Politician $politician): ?WipCount
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('politician', $politician))
            ->setMaxResults(1);

        $result = $this->getWipCounts()->matching($criteria)->first();

        if (false === $result) {
            return null;
        }

        return $result;
    }

    public function getEntryCountByPolitician(Politician $politician): int
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('politician', $politician));

        return \count($this->getCampaignEntries()->matching($criteria));
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

    /**
     * @return Collection|Page[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setCampaign($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->contains($page)) {
            $this->pages->removeElement($page);
            // set the owning side to null (unless already changed)
            if ($page->getCampaign() === $this) {
                $page->setCampaign(null);
            }
        }

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

    public function getCampaignTitle(): ?string
    {
        return $this->campaignTitle;
    }

    public function setCampaignTitle(string $campaignTitle = null): self
    {
        $this->campaignTitle = $campaignTitle;

        return $this;
    }

    public function getCampaignDescription(): ?string
    {
        return $this->campaignDescription;
    }

    public function setCampaignDescription(string $campaignDescription = null): self
    {
        $this->campaignDescription = $campaignDescription;

        return $this;
    }

    public function getOgCampaignDescription(): ?string
    {
        return $this->ogCampaignDescription;
    }

    public function setOgCampaignDescription(string $ogCampaignDescription = null): self
    {
        $this->ogCampaignDescription = $ogCampaignDescription;

        return $this;
    }

    public function setOgImageFileDe(SymfonyFile $ogImage = null): self
    {
        $this->ogImageFileDe = $ogImage;

        if ($ogImage) {
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    public function getOgImageFileDe(): ?SymfonyFile
    {
        return $this->ogImageFileDe;
    }

    public function setOgImageDe(?string $ogImage): self
    {
        $this->ogImageDe = $ogImage ?? '';

        return $this;
    }

    public function getOgImageDe(): ?string
    {
        return $this->ogImageDe;
    }

    public function setOgImageFileFr(SymfonyFile $ogImage = null): self
    {
        $this->ogImageFileFr = $ogImage;

        if ($ogImage) {
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    public function getOgImageFileFr(): ?SymfonyFile
    {
        return $this->ogImageFileFr;
    }

    public function setOgImageFr(?string $ogImage): self
    {
        $this->ogImageFr = $ogImage ?? '';

        return $this;
    }

    public function getOgImageFr(): ?string
    {
        return $this->ogImageFr;
    }

    public function getHero(): ?string
    {
        return $this->hero;
    }

    public function setHero(string $hero = null): self
    {
        $this->hero = $hero;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total = null): self
    {
        $this->total = $total;

        return $this;
    }

    public function getCampaignInfoLead(): ?string
    {
        return $this->campaignInfoLead;
    }

    public function setCampaignInfoLead(string $campaignInfoLead = null): self
    {
        $this->campaignInfoLead = $campaignInfoLead;

        return $this;
    }

    public function getCampaignInfo(): ?string
    {
        return $this->campaignInfo;
    }

    public function setCampaignInfo(string $campaignInfo = null): self
    {
        $this->campaignInfo = $campaignInfo;

        return $this;
    }

    public function getHowItWorksStep1(): ?string
    {
        return $this->howItWorksStep1;
    }

    public function setHowItWorksStep1(string $howItWorksStep1 = null): self
    {
        $this->howItWorksStep1 = $howItWorksStep1;

        return $this;
    }

    public function getHowItWorksStep2(): ?string
    {
        return $this->howItWorksStep2;
    }

    public function setHowItWorksStep2(string $howItWorksStep2 = null): self
    {
        $this->howItWorksStep2 = $howItWorksStep2;

        return $this;
    }

    public function getHowItWorksStep3(): ?string
    {
        return $this->howItWorksStep3;
    }

    public function setHowItWorksStep3(string $howItWorksStep3 = null): self
    {
        $this->howItWorksStep3 = $howItWorksStep3;

        return $this;
    }

    public function getHowItWorksFinish(): ?string
    {
        return $this->howItWorksFinish;
    }

    public function setHowItWorksFinish(string $howItWorksFinish = null): self
    {
        $this->howItWorksFinish = $howItWorksFinish;

        return $this;
    }

    public function getDonorBox(): ?string
    {
        return $this->donorBox;
    }

    public function setDonorBox(string $donorBox = null): self
    {
        $this->donorBox = $donorBox;

        return $this;
    }

    public function getShareTextBox(): ?string
    {
        return $this->shareTextBox;
    }

    public function setShareTextBox(string $shareTextBox = null): self
    {
        $this->shareTextBox = $shareTextBox;

        return $this;
    }

    public function getFaqTitle(): ?string
    {
        return $this->faqTitle;
    }

    public function setFaqTitle(string $faqTitle = null): self
    {
        $this->faqTitle = $faqTitle;

        return $this;
    }

    public function getFaqText(): ?string
    {
        return $this->faqText;
    }

    public function setFaqText(string $faqText = null): self
    {
        $this->faqText = $faqText;

        return $this;
    }

    public function getHeroBackground(): ?string
    {
        return $this->heroBackground;
    }

    public function setHeroBackground(string $heroBackground = null): self
    {
        $this->heroBackground = $heroBackground;

        return $this;
    }

    public function getHeroBackgroundFile(): ?SymfonyFile
    {
        return $this->heroBackgroundFile;
    }

    public function setHeroBackgroundFile(SymfonyFile $heroBackgroundFile = null): self
    {
        if ($heroBackgroundFile) {
            $this->updatedAt = new \DateTime();
        }

        $this->heroBackgroundFile = $heroBackgroundFile;

        return $this;
    }

    public function getMailThanksText(): ?string
    {
        return $this->mailThanksText;
    }

    public function setMailThanksText(?string $mailThanksText): self
    {
        $this->mailThanksText = $mailThanksText;

        return $this;
    }

    public function isDoubleOptIn(): bool
    {
        return $this->doubleOptIn;
    }

    public function setDoubleOptIn(bool $doubleOptIn): self
    {
        $this->doubleOptIn = $doubleOptIn;

        return $this;
    }

    public function getHeroSubline(): ?string
    {
        return $this->heroSubline;
    }

    public function setHeroSubline(?string $heroSubline): self
    {
        $this->heroSubline = $heroSubline;

        return $this;
    }

    public function addColor(Color $color): self
    {
        $this->colors->add($color);

        return $this;
    }

    public function removeColor(Color $color): self
    {
        $this->colors->removeElement($color);

        return $this;
    }

    public function getColors(): Collection
    {
        return $this->colors;
    }

    public function setColors(Collection $colors): self
    {
        $this->colors = $colors;

        return $this;
    }
}
