<?php

namespace App\Controller;

use App\Repository\ArtworkRepository;
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
    public function index(): Response
    {
        $artworks = $this->artworkRepository->findAll();

        return $this->render('main/index.html.twig', [
            'artworks' => $artworks,
            'controller_name' => 'MainController',
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
