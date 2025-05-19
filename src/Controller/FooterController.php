<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FooterController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_legal_notice', methods: ['GET', 'POST'])]
    public function legalNotices(): Response
    {
        
        return $this->render('footer/legal_notice.html.twig', []);
    
    
    }
    
    #[Route('/cgv', name: 'app_cgv', methods: ['GET', 'POST'])]
    public function cgv(): Response
    {
        
        return $this->render('footer/cgv.html.twig', []);
    
    
    }
    #[Route('/recrutement', name: 'app_recruitment', methods: ['GET', 'POST'])]
    public function recruitment(): Response
    {
        
        return $this->render('footer/recruitment.html.twig', []);
    
    
    }
    #[Route('/nous-contacter', name: 'app_contact', methods: ['GET', 'POST'])]
    public function conatct(): Response
    {
        
        return $this->render('footer/contact.html.twig', []);
    
    
    }
























}
