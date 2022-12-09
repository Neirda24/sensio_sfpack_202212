<?php

namespace App\Controller;

use App\Service\Movies;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movies/{slug<[a-zA-Z0-9-]+>}', name: 'app_movie', methods: ['GET'])]
    public function details(string $slug): Response
    {
        return $this->render('movie/index.html.twig', [
            'movie' => Movies::findOneBySlug($slug),
        ]);
    }
}
