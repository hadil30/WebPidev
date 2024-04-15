<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class quizController extends AbstractController
{
    #[Route('/user/quiz', name: 'user_quiz')]
    public function index(): Response
    {
        return $this->render('pages/user/quiz.html.twig');
    }
}
