<?php

namespace App\Controller;

use App\Entity\Questiont;
use App\Entity\Test;
use App\Repository\TestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form;
use App\Form\QuestiontType;
use App\Form\SimpleQuestionFormType;
use TestType;
use Symfony\Component\Serializer\SerializerInterface;


class AdminController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/users', name: 'admin_users')]
    public function users(): Response
    {
        return $this->render('pages/Admin/useradmin.html.twig');
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



    #[Route('/admin/test/add', name: 'admin_testadd')]
    public function newtest(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    { {
            $test = new Test();
            $form = $this->createForm(TestType::class, $test);
            $form->handleRequest($request);
            $errors = $form->getErrors(true);


            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    $entityManager->persist($test);
                    $entityManager->flush();
                    $this->addFlash('success', 'Test created successfully.');
                    return $this->redirectToRoute('admin_test');
                } else {
                    foreach ($form->getErrors(true) as $error) {
                        // echo $error->getMessage();
                    }
                }
            }
            return $this->render('pages/Admin/addTestadmin.html.twig', [
                'form' => $form->createView(),
                'errors' => $form->getErrors(true, true),
            ]);
        }
    }




    #[Route('/admin/test', name: 'admin_test')]

    public function test(TestRepository $testRepository): Response
    {
        $test = $testRepository->findAll();


        return $this->render('pages/Admin/testadmin.html.twig', [
            'test' => $test,
        ]);
    }

    #[Route('/admin/test/update/{id}', name: 'admin_testupdate')]
    public function testUpdate(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $test = $this->getDoctrine()->getRepository(Test::class)->find($id);

        if (!$test) {
            throw $this->createNotFoundException('The test does not exist');
        }

        $form = $this->createForm(TestType::class, $test);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($test);
            $entityManager->flush();

            $this->addFlash('success', 'Test updated successfully.');

            return $this->redirectToRoute('admin_test');
        } else {
            foreach ($form->getErrors(true) as $error) {
                // echo $error->getMessage();
            }
        }

        return $this->render('pages/Admin/updateTestAdmin.html.twig', [
            'form' => $form->createView(),
            'test' => $test,
            'errors' => $form->getErrors(true, true),

        ]);
    }


    #[Route('/admin/test/delete/{id}', name: 'test_delete')]

    public function deleteTest(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $test = $entityManager->getRepository(Test::class)->find($id);

        if (!$test) {
            throw $this->createNotFoundException('No test found for id ' . $id);
        }

        $entityManager->remove($test);
        $entityManager->flush();

        $this->addFlash('success', 'Test successfully deleted.');

        return $this->redirectToRoute('admin_test'); // Redirect to the route where you list the tests
    }


    #[Route('/admin/cours', name: 'admin_cours')]

    public function newQuestion(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $question = new Questiont();
        $form = $this->createForm(QuestiontType::class, $question);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($question);
            $entityManager->flush();
        }
        $formDataJson = $serializer->serialize($form->getData(), 'json');

        return $this->render('pages/Admin/coursadmin.html.twig', [
            'form' => $form->createView(),
            'formdata' => $formDataJson, // Pass the serialized data

        ]);
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
