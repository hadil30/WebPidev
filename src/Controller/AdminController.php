<?php

namespace App\Controller;

use App\Entity\Events;
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
use App\Repository\EventRepository;
use TestType;
use EventType;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\EventDispatcher\Event;

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

    #[Route('/admin/test', name: 'admin_test')]
    public function test(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {

        return $this->render('pages/Admin/testadmin.html.twig');
    }




    #[Route('/admin/event/add', name: 'admin_eventadd')]
    public function newEvent(Request $request,EntityManagerInterface $entityManager): Response
    {
        $event = new Events();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('admin_event', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/Admin/addeventadmin.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }





    #[Route('/admin/event/update/{EVENT_ID}', name: 'admin_details')]

    public function eventdetails(Request $request,$EVENT_ID,Events $event,EntityManagerInterface $entityManager,): Response
    {
        $event = $this->getDoctrine()->getRepository(Events::class)->find($EVENT_ID);

        if (!$event) {
            throw $this->createNotFoundException('The test does not exist');
        }

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            $this->addFlash('success', 'Event updated successfully.');

            return $this->redirectToRoute('admin_eventupdate');
        }

        return $this->render('pages/Admin/detailevent.html.twig', [
            'form' => $form->createView(),
            'event' => $event,
            
        ]);
    }




    #[Route('/admin/event/update', name: 'admin_eventupdate')]

    public function updateevent(EventRepository $eventRepository): Response
    {
        $event = $eventRepository->findAll();


        return $this->render('pages/Admin/updateeventadmin.html.twig', [
            'event' => $event,
        ]);
    }


    #[Route('/admin/event/delete/{EVENT_ID}', name: 'event_delete')]

    public function deleteevent( EntityManagerInterface $entityManager, $EVENT_ID): Response
    {
        $event = $entityManager->getRepository(Events::class)->find($EVENT_ID);

        if (!$event) {
            throw $this->createNotFoundException('No test found for id ' . $EVENT_ID);
        }

        $entityManager->remove($event);
        $entityManager->flush();

        $this->addFlash('success', 'event successfully deleted.');

        return $this->redirectToRoute('admin_eventupdate'); // Redirect to the route where you list the events
    }












    #[Route('/admin/test/add', name: 'admin_testadd')]
    public function newtest(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
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
            // $formDataJson = $serializer->serialize($form->getData(), 'json');


            return $this->render('pages/Admin/addTestadmin.html.twig', [
                'form' => $form->createView(),
                //  'formdata' => $formDataJson, 
            ]);
        }
    }




    #[Route('/admin/test/update', name: 'admin_testupdate')]

    public function updatetest(TestRepository $testRepository): Response
    {
        $test = $testRepository->findAll();


        return $this->render('pages/Admin/updateTestAdmin.html.twig', [
            'test' => $test,
        ]);
    }

    #[Route('/admin/test/update/{id}', name: 'test_detail')]
    public function testDetail(Request $request, $id, EntityManagerInterface $entityManager,): Response
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

            return $this->redirectToRoute('admin_testupdate');
        }

        return $this->render('pages/Admin/detailtest.html.twig', [
            'form' => $form->createView(),
            'test' => $test,
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

        return $this->redirectToRoute('admin_testupdate'); // Redirect to the route where you list the tests
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
