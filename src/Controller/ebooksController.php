<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ebooksController extends AbstractController
{
    #[Route('/user/ebooks', name: 'user_ebooks')]
    public function index(): Response
    {
        return $this->render('pages/user/ebooks.html.twig');
    }
}
