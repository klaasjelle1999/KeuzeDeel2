<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExtraInformationRepository")
 */
class ExtraInformation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $contactHours;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $internshipHours;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $examination;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $cost;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactHours(): ?string
    {
        return $this->contactHours;
    }

    public function setContactHours(?string $contactHours): self
    {
        $this->contactHours = $contactHours;

        return $this;
    }

    public function getInternshipHours(): ?string
    {
        return $this->internshipHours;
    }

    public function setInternshipHours(?string $internshipHours): self
    {
        $this->internshipHours = $internshipHours;

        return $this;
    }

    public function getExamination(): ?string
    {
        return $this->examination;
    }

    public function setExamination(?string $examination): self
    {
        $this->examination = $examination;

        return $this;
    }

    public function getCost(): ?string
    {
        return $this->cost;
    }

    public function setCost(?string $cost): self
    {
        $this->cost = $cost;

        return $this;
    }
}
