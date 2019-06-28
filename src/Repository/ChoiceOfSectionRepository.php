<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\ChoiceOfSection;
use App\Entity\PartOfDay;
use App\Entity\Period;
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
            ->andWhere('partOfDay.id =' . $partOfDay->getId())
            ->andWhere('tier.id =' . $tier->getId())
            ->getQuery()
            ->getResult();
    }

    public function filterChoiceOfSectionsV2(Category $category = null, Tier $tier = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.category', 'category')
            ->leftJoin('c.tier', 'tier')
            ->where('category.id =' . $category->getId())
            ->andWhere('tier.id =' . $tier->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterChoiceOfSectionsV3(PartOfDay $partOfDay = null, Tier $tier = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.partOfDay', 'partOfDay')
            ->leftJoin('c.tier', 'tier')
            ->where('partOfDay.id =' . $partOfDay->getId())
            ->andWhere('tier.id =' . $tier->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterChoiceOfSectionsV4(Category $category = null, PartOfDay $partOfDay = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.category', 'category')
            ->leftJoin('c.partOfDay', 'partOfDay')
            ->where('category.id =' . $category->getId())
            ->andWhere('partOfDay.id =' . $partOfDay->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterChoiceOfSectionsV5(Tier $tier = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.tier', 'tier')
            ->where('tier.id =' . $tier->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterChoiceOfSectionsV6(PartOfDay $partOfDay = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.partOfDay', 'partOfDay')
            ->where('partOfDay.id =' . $partOfDay->getId())
            ->getQuery()
            ->getResult()
        ;    
    }

    public function filterChoiceOfSectionsV7(Category $category = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.category', 'category')
            ->where('category.id =' . $category->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterChoiceOfSectionsV8(Category $category = null, PartOfDay $partOfDay = null, Tier $tier = null, Period $period = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.category', 'category')
            ->leftJoin('c.partOfDay', 'partOfDay')
            ->leftJoin('c.tier', 'tier')
            ->leftJoin('c.period', 'period')
            ->where('category.id =' . $category->getId())
            ->andWhere('partOfDay.id =' . $partOfDay->getId())
            ->andWhere('tier.id =' . $tier->getId())
            ->andWhere('period.id =' . $period->getId())
            ->getQuery()
            ->getResult();
    }

    public function filterChoiceOfSectionsV9(Category $category = null, Period $period = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.period', 'period')
            ->leftJoin('c.category', 'category')
            ->where('period.id =' . $period->getId())
            ->andWhere('category.id =' . $category->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterChoiceOfSectionsV10(PartOfDay $partOfDay = null, Period $period = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.partOfDay', 'partOfDay')
            ->leftJoin('c.period', 'period')
            ->where('partOfDay.id =' . $partOfDay->getId())
            ->andWhere('period.id =' . $period->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterChoiceOfSectionsV11(Tier $tier = null, Period $period = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.tier', 'tier')
            ->leftJoin('c.period', 'period')
            ->where('tier.id =' . $tier->getId())
            ->andWhere('period.id = ' . $period->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterChoiceOfSectionsV12(Period $period = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.period', 'period')
            ->where('period.id =' . $period->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterChoiceOfSectionsV13(PartOfDay $partOfDay = null, Tier $tier = null, Period $period = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.partOfDay', 'partOfDay')
            ->leftJoin('c.tier', 'tier')
            ->leftJoin('c.period', 'period')
            ->where('partOfDay.id =' . $partOfDay->getId())
            ->andWhere('tier.id =' . $tier->getId())
            ->andWhere('period.id =' . $period->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterChoiceOfSectionsV14(Category $category = null, PartOfDay $partOfDay = null, Period $period = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.category', 'category')
            ->leftJoin('c.partOfDay', 'partOfDay')
            ->leftJoin('c.period', 'period')
            ->where('category.id =' . $category->getId())
            ->andWhere('partOfDay.id =' . $partOfDay->getId())
            ->andWhere('period.id =' . $period->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterChoiceOfSectionsV15(Category $category = null, Tier $tier = null, Period $period = null)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.category', 'category')
            ->leftJoin('c.tier', 'tier')
            ->leftJoin('c.period', 'period')
            ->where('category.id =' . $category->getId())
            ->andWhere('tier.id =' . $tier->getId())
            ->andWhere('period.id =' . $period->getId())
            ->getQuery()
            ->getResult()
        ;
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
