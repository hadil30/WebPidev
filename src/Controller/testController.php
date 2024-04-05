<?php

namespace App\Controller;

use App\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class testController extends AbstractController
{


    #[Route('/user/test', name: 'user_test')]
    public function index(): Response
    {
        return $this->render('pages/user/test.html.twig');
    }
}
