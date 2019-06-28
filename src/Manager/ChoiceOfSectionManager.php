<?php

namespace App\Manager;

use App\Entity\Category;
use App\Entity\ChoiceOfSection;
use App\Entity\ExtraInformation;
use App\Entity\Period;
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
        $extraInformation = new ExtraInformation();

        $extraInformation
            ->setContactHours($data->contact_hours)
            ->setCost($data->cost)
            ->setExamination($data->examination)
            ->setInternshipHours($data->internship_hours)
        ;

        $choiceOfSection
            ->setName($data->name)
            ->setCategory($data->category)
            ->setPartOfDay($data->partOfDay)
            ->setTier($data->tier)
            ->setExtraInformation($extraInformation)
        ;

        $this->em->persist($extraInformation);
        $this->em->persist($choiceOfSection);
        $this->em->flush();
    }

    public function updateChoiceOfSection($data, ChoiceOfSection $choiceOfSection, ExtraInformation $extraInformation)
    {
        $extraInformation
            ->setContactHours($data->contact_hours)
            ->setInternshipHours($data->internship_hours)
            ->setExamination($data->examination)
            ->setCost($data->cost)
        ;

        $choiceOfSection
            ->setName($data->name)
            ->setCategory($data->category)
            ->setTier($data->tier)
            ->setPartOfDay($data->partOfDay)
            ->setDescription($data->description)
        ;

        $this->em->merge($extraInformation);
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

    public function addPeriodToChoiceOfSection(ChoiceOfSection $choiceOfSection, array $periods)
    {
        // Alle Periodes van Keuzedeel verwijderen
        $allPeriodsFromChoiceOfSection = $this->em->getRepository(Period::class)->findAllPeriodsForChoiceOfSection($choiceOfSection);
        foreach ($allPeriodsFromChoiceOfSection as $period) {
            $choiceOfSection->removePeriod($period);
            $this->em->merge($choiceOfSection);
        }

        // Periodes aan Keuzedeel toevoegen
        unset($periods['submitperiod']);
        foreach ($periods as $period) {
            $periode = $this->em->getRepository(Period::class)->find($period);
            $choiceOfSection->addPeriod($periode);

            $this->em->merge($choiceOfSection);
        }
        $this->em->flush();
    }
}