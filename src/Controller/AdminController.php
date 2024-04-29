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
use App\Repository\TestUtilisateurRepository;
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



            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    $entityManager->persist($test);
                    $entityManager->flush();
                    $this->addFlash('success', 'Test created successfully.');
                    return $this->redirectToRoute('admin_test');
                } else {
                    foreach ($form->getErrors(true) as $error) {
                        echo $error->getMessage();
                    }
                }
            }
            return $this->render('pages/Admin/addTestadmin.html.twig', [
                'form' => $form->createView(),
                'errors' => (string) $form->getErrors(true, false)
            ]);
        }
    }




    #[Route('/admin/test', name: 'admin_test')]

    public function test(TestRepository $testRepository, TestUtilisateurRepository $testUtilisateurRepository): Response
    {
        $test = $testRepository->findAll();
        $totalTests = $this->getDoctrine()->getManager('default')->getRepository(Test::class)->getTotalNumberOfTests();
        $activeTests = $this->getDoctrine()->getManager('default')->getRepository(Test::class)->getNumberOfActiveTests();
        $inactiveTests = $this->getDoctrine()->getManager('default')->getRepository(Test::class)->getNumberOfInactiveTests();
        $averageQuestions = $this->getDoctrine()->getManager('default')->getRepository(Test::class)->calculateAverageQuestionsPerTest();
        $averageDuration = $this->getDoctrine()->getManager('default')->getRepository(Test::class)->calculateAverageDuration();




        $scores = $testUtilisateurRepository->getHighestScoresByTest();

        $testNames = [];
        $highestScores = [];

        foreach ($scores as $score) {
            $testNames[] = $score['testName'];
            $highestScores[] = $score['maxScore'];
        }

        return $this->render('pages/Admin/testadmin.html.twig', [
            'test' => $test,
            'testNames' => json_encode($testNames),
            'highestScores' => json_encode($highestScores),
            'totalTests' => $totalTests,
            'activeTests' => $activeTests,
            'inactiveTests' => $inactiveTests,
            'averageQuestions' => $averageQuestions,
            'averageDuration' => $averageDuration,

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
}
