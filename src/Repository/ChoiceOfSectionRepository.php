<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\ChoiceOfSection;
use App\Entity\PartOfDay;
use App\Entity\Tier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ChoiceOfSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChoiceOfSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChoiceOfSection[]    findAll()
 * @method ChoiceOfSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChoiceOfSectionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ChoiceOfSection::class);
    }

    public function findNonDeletedChoiceOfSections()
    {
        return $this->createQueryBuilder('c')
            ->where('c.deletedAt is NULL')
            ->getQuery()
            ->getResult();
    }

    public function filterChoiceOfSections(Category $category = null, PartOfDay $partOfDay = null, Tier $tier = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.category', 'category')
            ->leftJoin('c.partOfDay', 'partOfDay')
            ->leftJoin('c.tier', 'tier')
            ->where('category.id =' . $category->getId())
            ->orWhere('partOfDay.id =' . $partOfDay->getId())
            ->orWhere('tier.id =' . $tier->getId())
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return ChoiceOfSection[] Returns an array of ChoiceOfSection objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChoiceOfSection
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
