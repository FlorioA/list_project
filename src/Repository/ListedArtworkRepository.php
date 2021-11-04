<?php

namespace App\Repository;

use App\Entity\Artwork;
use App\Entity\ListedArtwork;
use App\Entity\User;
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

    public function findOneByArtworkUser(Artwork $artwork, User $user)
    {
        return $this->createQueryBuilder('la')
            ->andWhere('la.artwork = :artwork')
            ->andWhere('la.user = :user')
            ->setParameter('artwork', $artwork)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
