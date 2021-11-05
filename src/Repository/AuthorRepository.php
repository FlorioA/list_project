<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Author;
use App\Entity\Artwork;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findByArtwork(Artwork $artwork)
    {
        return $this->createQueryBuilder('au')
            ->innerJoin('au.artworks', 'ar')
            ->andWhere('ar.id = :artwork')
            ->setParameter('artwork', $artwork)
            ->getQuery()
            ->getResult();
    }

    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
