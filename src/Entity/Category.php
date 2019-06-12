<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\OneToMany(targetEntity="App\Entity\ChoiceOfSection", mappedBy="category")
     */
    private $choiceOfSections;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct()
    {
        $this->choiceOfSections = new ArrayCollection();
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
            $choiceOfSection->setCategory($this);
        }

        return $this;
    }

    public function removeChoiceOfSection(ChoiceOfSection $choiceOfSection): self
    {
        if ($this->choiceOfSections->contains($choiceOfSection)) {
            $this->choiceOfSections->removeElement($choiceOfSection);
            // set the owning side to null (unless already changed)
            if ($choiceOfSection->getCategory() === $this) {
                $choiceOfSection->setCategory(null);
            }
        }

        return $this;
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
}
