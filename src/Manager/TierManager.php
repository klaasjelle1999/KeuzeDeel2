<?php


namespace App\Manager;


use App\Entity\Tier;
use Doctrine\ORM\EntityManagerInterface;

class TierManager
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createTier($data)
    {
        $tier = new Tier();

        $tier->setNiveau($data->niveau);

        $this->em->persist($tier);
        $this->em->flush();
    }

    public function deleteTier(Tier $tier)
    {
        $this->em->remove($tier);
        $this->em->flush();
    }
}