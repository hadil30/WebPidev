<?php

namespace App\Controller;

use App\Entity\Test;
use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class testController extends AbstractController
{


    #[Route('/user/test', name: 'user_test')]
    public function index(TestRepository $testRepository): Response
    {
        $test = $testRepository->findAll();


        return $this->render('pages/user/test.html.twig', [
            'test' => $test,
        ]);
    }
}
