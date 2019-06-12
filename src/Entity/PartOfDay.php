<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartOfDayRepository")
 */
class PartOfDay
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
    private $partOfDay;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ChoiceOfSection", mappedBy="partOfDay", orphanRemoval=true)
     */
    private $choiceOfSections;

    public function __construct()
    {
        $this->choiceOfSections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartOfDay(): ?string
    {
        return $this->partOfDay;
    }

    public function setPartOfDay(string $partOfDay): self
    {
        $this->partOfDay = $partOfDay;

        return $this;
    }

    /**
     * @return Collection|ChoiceOfSection[]
     */
    public function getChoiceOfSections(): Collection
    {
        return $this->choiceOfSections;
    }

    public function addChoiceOfSection(ChoiceOfSection $choiceOfSection): self
    {
        if (!$this->choiceOfSections->contains($choiceOfSection)) {
            $this->choiceOfSections[] = $choiceOfSection;
            $choiceOfSection->setPartOfDay($this);
        }

        return $this;
    }

    public function removeChoiceOfSection(ChoiceOfSection $choiceOfSection): self
    {
        if ($this->choiceOfSections->contains($choiceOfSection)) {
            $this->choiceOfSections->removeElement($choiceOfSection);
            // set the owning side to null (unless already changed)
            if ($choiceOfSection->getPartOfDay() === $this) {
                $choiceOfSection->setPartOfDay(null);
            }
        }

        return $this;
    }
}
