<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user/{userId}")
 * @Entity("user", expr="repository.find(userId)")
 */
class AuthorController extends AbstractController
{
    private AuthorRepository $authorRepository;

    private EntityManagerInterface $em;

    public function __construct(AuthorRepository $authorRepository, EntityManagerInterface $em)
    {
        $this->authorRepository = $authorRepository;
        $this->em = $em;
    }

    /**
     * @Route("/authors", name="authors_show")
     */
    public function index(User $user): Response
    {
        $authors = $this->authorRepository->findByUser($user);

        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/author/new", name="author_new")
     * @Route("/author/{id}/edit", name="author_edit")
     */
    public function newAuthor(Request $request, User $user): Response
    {
        if ($request->get('id')) {
            $author = $this->authorRepository->find($request->get('id'));

            if ($author->getUser() !== $user) {
                throw new Exception("Author not found");
            }
        } else {
            $author = new Author();
        }

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Author $author */
            $author = $form->getData();

            // Update user
            $author->setUser($user);

            $this->em->persist($author);
            $this->em->flush();

            $this->addFlash('success', 'Author created !');

            return $this->redirectToRoute('authors_show', ['userId' => $user->getId()]);
        }

        return $this->render('author/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/author/{id}/delete", name="author_delete")
     */
    public function deleteArtwork(User $user, Author $author): Response
    {
        if ($author->getUser() !== $user) {
            $this->addFlash('danger', 'Artwork not found');
        } else {
            $this->em->remove($author);
            $this->em->flush();

            $this->addFlash('success', 'Artwork deleted');
        }

        return $this->redirectToRoute('authors_show', ['userId' => $user->getId()]);
    }
}
