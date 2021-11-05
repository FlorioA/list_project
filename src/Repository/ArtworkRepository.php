<?php

namespace App\Repository;

use App\Entity\Artwork;
use App\Entity\Media;
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

    public function findByUserBySeen(User $user, bool $seen)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.listedArtworks', 'la')
            ->andWhere('la.user = :user')
            ->andWhere('la.seen = :seen')
            ->setParameter('user', $user)
            ->setParameter('seen', $seen)
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

    public function searchQuery(string $artwork = null, string $author = null, ?Media $media = null)
    {
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.title', 'ASC');

        if ($artwork) {
            $qb
                ->andWhere('a.title LIKE :artwork')
                ->setParameter('artwork', '%' . $artwork . '%');
        }

        if ($author) {
            $qb
                ->join('a.authors', 'au')
                ->andWhere('au.name LIKE :author')
                ->setParameter('author', '%' . $author . '%');
        }

        if ($media) {
            $qb
                ->andWhere('a.media = :media')
                ->setParameter('media', $media);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function findAllOrderedBy(string $sort, string $order = 'ASC')
    {
        return $this->createQueryBuilder('a')
            ->orderBy("a.$sort", $order)
            ->getQuery()
            ->getResult();
    }
}
