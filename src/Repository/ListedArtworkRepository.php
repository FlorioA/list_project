<?php

namespace App\Repository;

use App\Entity\ListedArtwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListedArtwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListedArtwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListedArtwork[]    findAll()
 * @method ListedArtwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListedArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListedArtwork::class);
    }

    // /**
    //  * @return ListedArtwork[] Returns an array of ListedArtwork objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListedArtwork
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
