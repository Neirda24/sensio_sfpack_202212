<?php

namespace App\Controller;

use App\Form\MovieType;
use App\ReadModel\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movies/{slug<[a-zA-Z0-9-]+>}', name: 'movie_details', methods: ['GET'], priority: -100)]
    public function details(MovieRepository $movieRepository, string $slug): Response
    {
        return $this->render('movie/index.html.twig', [
            'movie' => Movie::fromEntity($movieRepository->fetchOneBySlug($slug)),
        ]);
    }

    #[Route('/movies/add', name: 'movie_add', methods: ['GET', 'POST'])]
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
