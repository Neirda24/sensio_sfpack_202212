<?php

namespace App\Controller;

use App\ReadModel\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavBarController extends AbstractController
{
    public function index(MovieRepository $movieRepository, ?string $currentMovieSlug = null): Response
    {
        return $this->render('navbar.html.twig', [
            'movies'             => Movie::fromEntities($movieRepository->findAll()),
            'current_movie_slug' => $currentMovieSlug,
        ]);
    }
}
