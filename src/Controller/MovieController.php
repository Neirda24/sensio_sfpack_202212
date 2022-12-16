<?php

namespace App\Controller;

use App\Entity\Movie as MovieEntity;
use App\Form\MovieType;
use App\Omdb\ApiConsumerInterface;
use App\ReadModel\Movie;
use App\Repository\MovieRepository;
use App\Security\Voter\MovieVoter;
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
        private readonly ApiConsumerInterface $apiConsumer,
        private readonly SluggerInterface     $slugger,
        private readonly MovieRepository      $movieRepository,
    ) {
    }

    #[Route('/movies/{slug<[a-zA-Z0-9-]+>}', name: 'movie_details', methods: ['GET'], priority: -100)]
    public function details(string $slug): Response
    {
        try {
            $movie = Movie::fromEntity($this->movieRepository->fetchOneBySlug($slug));
        } catch (NoResultException) {
            try {
                $movie = Movie::fromOmdbApi($this->apiConsumer->getById($slug), $this->slugger);
            } catch (Throwable $throwable) {
                throw $this->createNotFoundException("Could not find the movie slug or OMDB ID : '{$slug}'", $throwable);
            }
        }

        $this->denyAccessUnlessGranted(MovieVoter::VIEW_DETAILS, $movie);

        return $this->render('movie/index.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/admin/movies/add', name: 'movie_add', methods: ['GET', 'POST'])]
    #[Route('/movies/{slug<[a-zA-Z0-9-]+>}/edit', name: 'movie_edit', methods: ['GET', 'POST'])]
    public function add(Request $request, ?string $slug): Response
    {
        $movie = new MovieEntity();

        if (null !== $slug) {
            $movie = $this->movieRepository->fetchOneBySlug($slug);
        }

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->movieRepository->save($movie, true);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('movie/add.html.twig', ['form' => $form]);
    }

    #[Route('/movies/{slug<[a-zA-Z0-9-]+>}/delete', name: 'movie_delete', methods: ['GET'])]
    public function delete(string $slug): Response
    {
        try {
            $movie = $this->movieRepository->fetchOneBySlug($slug);
        } catch (NoResultException) {
            return $this->redirectToRoute('app_home');
        }

        $this->movieRepository->remove($movie, true);

        return $this->redirectToRoute('app_home');
    }
}
