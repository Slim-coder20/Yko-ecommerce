<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            
        ]);
    }
    
    // Route pour le catalogue de produits // 
   
     #[Route('/catalogue', name: 'app_catalog', methods: ['GET', 'POST'])]
    public function catalog(): Response
    {
        return $this->render('home/catalog.html.twig', [
            
        ]);
    }
}
