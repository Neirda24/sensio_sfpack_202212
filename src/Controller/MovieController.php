<?php

namespace App\Controller;

use App\Entity\Movie as MovieEntity;
use App\Form\MovieType;
use App\Omdb\ApiConsumer;
use App\ReadModel\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Throwable;

class MovieController extends AbstractController
{
    public function __construct(
        private readonly ApiConsumer      $apiConsumer,
        private readonly SluggerInterface $slugger,
    ) {
    }

    #[Route('/movies/{slug<[a-zA-Z0-9-]+>}', name: 'movie_details', methods: ['GET'], priority: -100)]
    public function details(MovieRepository $movieRepository, string $slug): Response
    {
        try {
            $movie = Movie::fromEntity($movieRepository->fetchOneBySlug($slug));
        } catch (NoResultException) {
            try {
                $movie = Movie::fromOmdbApi($this->apiConsumer->getById($slug), $this->slugger);
            } catch (Throwable) {
                throw $this->createNotFoundException("Could not find the movie slug or OMDB ID : '{$slug}'");
            }
        }

        return $this->render('movie/index.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/movies/add', name: 'movie_add', methods: ['GET', 'POST'])]
    #[Route('/movies/{slug<[a-zA-Z0-9-]+>}/edit', name: 'movie_edit', methods: ['GET', 'POST'])]
    public function add(Request $request, MovieRepository $movieRepository, ?string $slug): Response
    {
        $movie = new MovieEntity();

        if (null !== $slug) {
            $movie = $movieRepository->fetchOneBySlug($slug);
        }

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movieRepository->save($movie, true);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('movie/add.html.twig', ['form' => $form]);
    }

    #[Route('/movies/{slug<[a-zA-Z0-9-]+>}/delete', name: 'movie_delete', methods: ['GET'])]
    public function delete(Request $request, MovieRepository $movieRepository, string $slug): Response
    {
        try {
            $movie = $movieRepository->fetchOneBySlug($slug);
        } catch (NoResultException) {
            return $this->redirectToRoute('app_home');
        }

        $movieRepository->remove($movie, true);

        return $this->redirectToRoute('app_home');
    }
}
