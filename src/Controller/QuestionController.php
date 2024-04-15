<?php

namespace App\Controller;
namespace App\Controller;

use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\QuestionType;
use App\Entity\Question;

use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile; // Add this import statement

class QuestionController extends AbstractController
{
    #[Route('/user/quiz/question/{quiz}', name: 'app_question_show')]
    public function QuestionAction($quiz,QuestionRepository $questionRepository, EntityManagerInterface $entityManager,Request $request): Response
    {

        $question= $questionRepository->findByExampleField($request->get("quiz"));

        // Get all Quizs for display
        
    
        // Render the template with the form and Quizs data
        return $this->render('pages/user/questionlist.html.twig', [
            'questions' => $question,
            'quiz' => $quiz,
        ]);
    }
    #[Route('/user/questionAdd/{quiz}', name: 'app_question_add')]
    public function QuestionAdd($quiz,Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Create a new Quiz instance
        $question = new Question();
    
        // Create the form
        $form = $this->createForm(QuestionType::class, $question);
        // Handle form submission if the request is POST
        $form->handleRequest($request);
    
        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle quiz creation
            // Persist the quiz entity
            
    $question->quiz= $entityManager->getRepository(Quiz::class)->find($request->get("quiz"));
            $entityManager->persist($question);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_question_add', ['quiz' => $request->get("quiz")]);         
        }
    
        // Render the template with the form and Quiz data
        return $this->render('pages/user/QuestionAdd.html.twig', [
            'form' => $form->createView(),
            'quizId' => $quiz,
        ]);}
        
    #[Route('/user/questiondelete/{quiz}/{id}', name: 'question_data_del')]

    public function delete($quiz,$id,EntityManagerInterface $entityManager, QuestionRepository $questionRepository): Response
    {
        $question=$questionRepository->find($id);
    
        $entityManager->remove($question);
        $entityManager->flush();
        dump($question);
        return $this->redirectToRoute("app_question_show",['quiz' => $quiz]);
    }
    #[Route('/user/quiz/{quiz}/{id}', name: 'question_data_mod')]
    public function modify($quiz,$id, QuestionRepository $questionRepository, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $question = $questionRepository->find($id);
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload for the image field
            $question->quiz= $entityManagerInterface->getRepository(Quiz::class)->find($quiz);
            $entityManagerInterface->persist($question);
            $entityManagerInterface->flush();
    
            return $this->redirectToRoute("app_question_show",['quiz' => $quiz]);
        }
    
        return $this->render('pages/user/QuestionMod.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
