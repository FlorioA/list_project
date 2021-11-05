<?php

namespace App\Controller;

use App\Form\ArtworkSearchType;
use App\Repository\ArtworkRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private ArtworkRepository $artworkRepository;

    public function __construct(ArtworkRepository $artworkRepository)
    {
        $this->artworkRepository = $artworkRepository;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ArtworkSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchArtwork = $form->get('search_artwork')->getData();
            $searchAuthor = $form->get('search_author')->getData();
            $media = $form->get('media')->getData();

            $artworks = $this->artworkRepository->searchQuery($searchArtwork, $searchAuthor, $media);
        } else {
            $artworks = $this->artworkRepository->findAllOrderedBy('title');
        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
            'artworks' => $artworks,
        ]);
    }

    /**
     * @Route("/menu", name="main_menu")
     */
    public function mainMenu(string $routeName)
    {
        return $this->render('_main_menu.html.twig', [
            'route_name' => $routeName
        ]);
    }
}
