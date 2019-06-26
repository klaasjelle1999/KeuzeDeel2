<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChoiceOfSectionRepository")
 */
class ChoiceOfSection
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="choiceOfSections")
     */
    private $category;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PartOfDay", inversedBy="choiceOfSections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfDay;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tier", inversedBy="choiceOfSections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tier;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ExtraInformation", cascade={"persist", "remove"})
     */
    private $extraInformation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Period", inversedBy="choiceOfSections")
     */
    private $period;

    public function __construct()
    {
        $this->period = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getPartOfDay(): ?PartOfDay
    {
        return $this->partOfDay;
    }

    public function setPartOfDay(?PartOfDay $partOfDay): self
    {
        $this->partOfDay = $partOfDay;

        return $this;
    }

    public function getTier(): ?Tier
    {
        return $this->tier;
    }

    public function setTier(?Tier $tier): self
    {
        $this->tier = $tier;

        return $this;
    }

    public function getExtraInformation(): ?ExtraInformation
    {
        return $this->extraInformation;
    }

    public function setExtraInformation(?ExtraInformation $extraInformation): self
    {
        $this->extraInformation = $extraInformation;

        return $this;
    }

    /**
     * @return Collection|Period[]
     */
    public function getPeriod(): Collection
    {
        return $this->period;
    }

    public function addPeriod(Period $period): self
    {
        if (!$this->period->contains($period)) {
            $this->period[] = $period;
        }

        return $this;
    }

    public function removePeriod(Period $period): self
    {
        if ($this->period->contains($period)) {
            $this->period->removeElement($period);
        }

        return $this;
    }
}
