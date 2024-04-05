<?php

namespace App\Controller;


use App\Entity\Test;
use App\Repository\TestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Form;
use TestType;

class AdminController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/users', name: 'admin_users')]
    public function users(UserRepository $UserRepository): Response
    {
        $users = $UserRepository->findAll();
        return $this->render('pages/Admin/useradmin.html.twig', ['users' => $users]);
    }
    #[Route('/admin/cours', name: 'admin_cours')]
    public function cours(): Response
    {
        return $this->render('pages/Admin/coursadmin.html.twig');
    }
    #[Route('/admin/ebook', name: 'admin_ebook')]
    public function ebook(): Response
    {
        return $this->render('pages/Admin/ebookadmin.html.twig');
    }
    #[Route('/admin/event', name: 'admin_event')]
    public function event(): Response
    {
        return $this->render('pages/Admin/eventadmin.html.twig');
    }

    #[Route('/admin/quiz', name: 'admin_quiz')]
    public function quiz(): Response
    {
        return $this->render('pages/Admin/quizadmin.html.twig');
    }
    /* #[Route('/admin/test', name: 'admin_test')]
    public function newTest(Request $request): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Iterate through associated Questiont entities to persist them
            foreach ($test->getQuestions() as $question) {
                if (!$this->entityManager->contains($question)) {
                    $this->entityManager->persist($question);
                    // Now iterate through each Reponse associated with the Questiont
                    // (Assuming you have a method in Test entity to get its Questions)
                }
            }

            $this->entityManager->persist($test);
            $this->entityManager->flush();

            $this->addFlash('success', 'Test created successfully.');

            return $this->redirectToRoute('admin_test');
        }

        return $this->render('pages/Admin/testadmin.html.twig', [
            'form' => $form->createView(),
        ]);
    }*/
    #[Route('/admin/test', name: 'admin_test')]
    public function newtest(Request $request, EntityManagerInterface $entityManager): Response
    { {
            $test = new Test();
            $form = $this->createForm(TestType::class, $test);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($test);
                $entityManager->flush();

                $this->addFlash('success', 'Test created successfully.');

                return $this->redirectToRoute('admin_test');
            }


            return $this->render('pages/Admin/testadmin.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }

    /*  #[Route('/admin/test', name: 'admin_test', methods: ['POST'])]
    public function newTest(Request $request): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());

            // Iterate through associated Questiont entities to persist them
            foreach ($test->getQuestions() as $question) {
                if (!$this->entityManager->contains($question)) {
                    $this->entityManager->persist($question);

                    foreach ($question->getReponses() as $reponse) {
                        if (!$this->entityManager->contains($reponse)) {
                            $this->entityManager->persist($reponse);
                        }
                    }
                }
            }

            $this->entityManager->persist($test);
            $this->entityManager->flush();

            $this->addFlash('success', 'Test created successfully.');



            // return $this->redirectToRoute('admin_test');
        }

        return $this->render('pages/Admin/testadmin.html.twig', [
            'form' => $form->createView(),
        ]);
    }*/
}
