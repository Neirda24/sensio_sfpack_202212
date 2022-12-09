<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello/{name}', name: 'app_hello', requirements: ['name' => '[a-zA-Z-]+'], methods: ['GET'])]
    public function index(string $name = 'Adrien'): Response
    {
        return new Response("<body>Hello {$name}</body>");
    }
}
