<?php

namespace App\Repository;

use App\Entity\ExtraInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ExtraInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExtraInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExtraInformation[]    findAll()
 * @method ExtraInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExtraInformationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExtraInformation::class);
    }

    // /**
    //  * @return ExtraInformation[] Returns an array of ExtraInformation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExtraInformation
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
