<?php

namespace App\Twig;

use App\Entity\Artwork;
use App\Entity\ListedArtwork;
use App\Entity\User;
use App\Repository\ListedArtworkRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private ListedArtworkRepository $listedArtworkRepository;

    public function __construct(ListedArtworkRepository $listedArtworkRepository)
    {
        $this->listedArtworkRepository = $listedArtworkRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('get_listed_artwork', [$this, 'getListedArtwork']),
        ];
    }

    public function getListedArtwork(Artwork $artwork, User $user): ?ListedArtwork
    {
        return $this->listedArtworkRepository->findOneByArtworkUser($artwork, $user);
    }
}
