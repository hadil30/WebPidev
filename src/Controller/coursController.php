<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class coursController extends AbstractController
{
    #[Route('/user/cours', name: 'user_cours')]
    public function index(): Response
    {
        return $this->render('pages/user/cours.html.twig');
    }

  

   

    
   
}
