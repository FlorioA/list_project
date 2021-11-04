<?php

namespace App\Controller;

use App\Entity\Artwork;
use App\Entity\ListedArtwork;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtworkController extends AbstractController
{
    /**
     * @Route("/artwork", name="artwork_show")
     */
    public function showArtwork(Artwork $artwork, ?ListedArtwork $listedArtwork): Response
    {
        return $this->render('artwork/_artwork.html.twig', [
            'artwork' => $artwork,
            'listed_artwork' => $listedArtwork
        ]);
    }
}
