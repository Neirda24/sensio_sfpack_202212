<?php

namespace App\Controller;

use App\ReadModel\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movies/{slug<[a-zA-Z0-9-]+>}', name: 'movie_details', methods: ['GET'])]
    public function details(MovieRepository $movieRepository, string $slug): Response
    {
        return $this->render('movie/index.html.twig', [
            'movie' => Movie::fromEntity($movieRepository->fetchOneBySlug($slug)),
        ]);
    }
}
