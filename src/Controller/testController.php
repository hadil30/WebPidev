<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
