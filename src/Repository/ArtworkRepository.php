<?php

namespace App\Repository;

use App\Entity\Artwork;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Artwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artwork[]    findAll()
 * @method Artwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artwork::class);
    }

    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.listedArtworks', 'la')
            ->andWhere('la.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
