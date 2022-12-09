<?php

namespace App\Controller;

use App\Service\Movies;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavBarController extends AbstractController
{
    public function index(?string $currentMovieSlug = null): Response
    {
        return $this->render('navbar.html.twig', [
            'movies'             => Movies::getMovies(),
            'current_movie_slug' => $currentMovieSlug,
        ]);
    }
}
