<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Artwork;
use App\Entity\ListedArtwork;
use App\Repository\ArtworkRepository;
use App\Repository\ListedArtworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user/{userId}/my-artworks")
 * @Entity("user", expr="repository.find(userId)")
 */
class ListedArtworkController extends AbstractController
{
    private EntityManagerInterface $em;

    private ListedArtworkRepository $listedArtworkRepository;

    private ArtworkRepository $artworkRepository;

    public function __construct(EntityManagerInterface $em, ListedArtworkRepository $listedArtworkRepository, ArtworkRepository $artworkRepository)
    {
        $this->em = $em;
        $this->listedArtworkRepository = $listedArtworkRepository;
        $this->artworkRepository = $artworkRepository;
    }

    /**
     * @Route("/", name="listed_artwork_list")
     */
    public function index(User $user): Response
    {
        $listedArtworks = $this->artworkRepository->findByUser($user);

        return $this->render('listed_artwork/index.html.twig', [
            'artworks' => $listedArtworks,
        ]);
    }

    /**
     * @Route("/{id}/add/{seen}", name="listed_artwork_add")
     */
    public function addListedArtwork(User $user, Artwork $artwork, bool $seen)
    {
        $listedArtwork = (new ListedArtwork())
            ->setUser($user)
            ->setArtwork($artwork)
            ->setSeen($seen);

        $this->em->persist($listedArtwork);
        $this->em->flush();

        $this->addFlash('success', 'Artwork added to your list !');

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/{id}/update/{seen}", name="listed_artwork_update")
     */
    public function updateListedArtwork(User $user, Artwork $artwork, bool $seen)
    {
        /** @var ListedArtwork $listedArtwork */
        $listedArtwork = $this->listedArtworkRepository->findOneByArtworkUser($artwork, $user);

        if ($listedArtwork->getSeen() !== $seen) {
            $listedArtwork->setSeen($seen);

            $this->em->persist($listedArtwork);
            $this->em->flush();
        }

        $this->em->persist($listedArtwork);
        $this->em->flush();

        $this->addFlash('success', 'Artwork updated in your list !');

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/{id}/remove", name="listed_artwork_remove")
     */
    public function removeListedArtwork(User $user, Artwork $artwork)
    {
        /** @var ListedArtwork $listedArtwork */
        $listedArtwork = $this->listedArtworkRepository->findOneByArtworkUser($artwork, $user);

        $this->em->remove($listedArtwork);
        $this->em->flush();

        $this->addFlash('success', 'Artwork removed from your list');

        return $this->redirectToRoute('home');
    }
}
