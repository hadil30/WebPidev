<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class userController extends AbstractController
{
    #[Route('/user/profile', name: 'user_profile')]
    public function index(): Response
    {
        return $this->render('pages/user/profile.html.twig');
    }
    #[Route('/user/ebook', name: 'user_ebook', methods: ['GET'])]
    public function ebookdisplay(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        return $this->render('pages/user/ebooks.html.twig', [
            'b' => $books,
        ]);
    }
}
