<?php

namespace App\Controller;

use App\ReadModel\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(MovieRepository $movieRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'movies' => Movie::fromEntities($movieRepository->findAll()),
        ]);
    }
}
