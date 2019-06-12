<?php

namespace App\Manager;

use App\Entity\Category;
use App\Entity\ChoiceOfSection;
use Doctrine\ORM\EntityManagerInterface;

class ChoiceOfSectionManager
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * ChoiceOfSectionManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $name
     * @param Category $category
     */
    public function createChoiceOfSection($data)
    {
        $choiceOfSection = new ChoiceOfSection();

        $choiceOfSection
            ->setName($data->name)
            ->setCategory($data->category)
            ->setPartOfDay($data->partOfDay)
            ->setTier($data->tier)
        ;

        $this->em->persist($choiceOfSection);
        $this->em->flush();
    }

    public function updateChoiceOfSection($data, ChoiceOfSection $choiceOfSection)
    {
        $choiceOfSection
            ->setName($data->name)
            ->setCategory($data->category)
            ->setTier($data->tier)
            ->setPartOfDay($data->partOfDay)
            ->setDescription($data->description)
        ;

        $this->em->merge($choiceOfSection);
        $this->em->flush();
    }

    public function deleteChoiceOfSection(ChoiceOfSection $choiceOfSection)
    {
        $choiceOfSection
            ->setDeletedAt(new \DateTime('now'))
        ;

        $this->em->merge($choiceOfSection);
        $this->em->flush();
    }

    public function activateChoiceOfSection(ChoiceOfSection $choiceOfSection)
    {
        $choiceOfSection
            ->setDeletedAt(null)
        ;

        $this->em->merge($choiceOfSection);
        $this->em->flush();
    }
}