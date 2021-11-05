<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Entity\ListedArtwork;
use App\Repository\MediaRepository;
use App\Repository\ArtworkRepository;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/user/{userId}")
 * @Entity("user", expr="repository.find(userId)")
 */
class ArtworkController extends AbstractController
{
    private ArtworkRepository $artworkRepository;

    private MediaRepository $mediaRepository;

    private AuthorRepository $authorRepository;

    private SluggerInterface $slugger;

    private EntityManagerInterface $em;

    public function __construct(ArtworkRepository $artworkRepository, MediaRepository $mediaRepository, AuthorRepository $authorRepository, SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $this->artworkRepository = $artworkRepository;
        $this->mediaRepository = $mediaRepository;
        $this->authorRepository = $authorRepository;
        $this->slugger = $slugger;
        $this->em = $em;
    }

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

    /**
     * @Route("/artworks", name="artworks_show")
     */
    public function showArtworks(User $user)
    {
        $artworks = $this->artworkRepository->findByUser($user);

        return $this->render('artwork/index.html.twig', [
            'artworks' => $artworks,
        ]);
    }

    /**
     * @Route("/artwork/new", name="artwork_new")
     * @Route("/artwork/{id}/edit", name="artwork_edit")
     */
    public function newArtwork(Request $request, User $user): Response
    {
        if ($request->get('id')) {
            $artwork = $this->artworkRepository->find($request->get('id'));

            if ($artwork->getUser() !== $user) {
                throw new Exception("Artwork not found");
            }
        } else {
            $artwork = new Artwork();
        }

        $medias = $this->mediaRepository->findAll();
        $mediasList = [];
        foreach ($medias as $media) {
            $mediasList[$media->getName()] = $media;
        }

        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Artwork $artwork */
            $artwork = $form->getData();

            // Handle image
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('artworks_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new FileException($e->getMessage());
                }

                $artwork->setImage($newFilename);
            }

            // Update user
            $artwork->setUser($user);

            $this->em->persist($artwork);
            $this->em->flush();

            $this->addFlash('success', 'Artwork created !');

            return $this->redirectToRoute('artworks_show', ['userId' => $user->getId()]);
        }

        return $this->render('artwork/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/artwork/{id}/delete", name="artwork_delete")
     */
    public function deleteArtwork(User $user, Artwork $artwork): Response
    {
        if ($artwork->getUser() !== $user) {
            $this->addFlash('danger', 'Artwork not found');
        } else {
            $this->em->remove($artwork);
            $this->em->flush();

            $this->addFlash('success', 'Artwork deleted');
        }

        return $this->redirectToRoute('artworks_show', ['userId' => $user->getId()]);
    }
}
