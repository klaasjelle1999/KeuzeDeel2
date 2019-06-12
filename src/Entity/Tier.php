<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TierRepository")
 */
class Tier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ChoiceOfSection", mappedBy="tier", orphanRemoval=true)
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

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

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
            $choiceOfSection->setTier($this);
        }

        return $this;
    }

    public function removeChoiceOfSection(ChoiceOfSection $choiceOfSection): self
    {
        if ($this->choiceOfSections->contains($choiceOfSection)) {
            $this->choiceOfSections->removeElement($choiceOfSection);
            // set the owning side to null (unless already changed)
            if ($choiceOfSection->getTier() === $this) {
                $choiceOfSection->setTier(null);
            }
        }

        return $this;
    }
}
