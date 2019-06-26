<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PeriodRepository")
 */
class Period
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $period;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ChoiceOfSection", mappedBy="period")
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

    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(string $period): self
    {
        $this->period = $period;

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
            $choiceOfSection->addPeriod($this);
        }

        return $this;
    }

    public function removeChoiceOfSection(ChoiceOfSection $choiceOfSection): self
    {
        if ($this->choiceOfSections->contains($choiceOfSection)) {
            $this->choiceOfSections->removeElement($choiceOfSection);
            $choiceOfSection->removePeriod($this);
        }

        return $this;
    }
}
