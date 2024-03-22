<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class eventController extends AbstractController
{
    #[Route('/user/event', name: 'user_event')]
    public function index(): Response
    {
        return $this->render('pages/user/event.html.twig');
    }
}
