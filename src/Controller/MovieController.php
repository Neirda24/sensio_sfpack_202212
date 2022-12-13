<?php

namespace App\Controller;

use App\Form\MovieType;
use App\Omdb\ApiConsumer;
use App\ReadModel\Movie;
use App\Repository\MovieRepository;
use App\Security\Voter\MovieVoter;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Throwable;

class MovieController extends AbstractController
{
    public function __construct(
        private readonly ApiConsumer $apiConsumer,
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

        $this->denyAccessUnlessGranted(MovieVoter::VIEW_DETAILS, $movie);

        return $this->render('movie/index.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/admin/movies/add', name: 'movie_add', methods: ['GET', 'POST'])]
    public function add(Request $request, MovieRepository $movieRepository): Response
    {
        $form = $this->createForm(MovieType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movieRepository->save($form->getData(), true);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('movie/add.html.twig', ['form' => $form]);
    }
}
