<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\QuizType;
use App\Entity\Quiz;

use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile; // Add this import statement

class quizController extends AbstractController
{
    private $entityManager;
  
    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
        $this->currentIndex = 0;
        $this->backIndex = 0;
        $this->questions = []; // Array to store questions   
    }
    #[Route('/user/quiz', name: 'app_quiz_show')]
    public function quizAction(QuizRepository $quizRepository): Response
    {
    
        // Get all Quizs for display
        $quizs = $quizRepository->findAll();
    
        // Render the template with the form and Quizs data
        return $this->render('pages/user/quiz.html.twig', [
            'quizs' => $quizs,
        ]);
    }
    #[Route('/user/quizAdd', name: 'app_quiz_add')]
    public function quizAdd(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Create a new Quiz instance
        $quiz = new Quiz();
        $quiz1=$quiz;
        // Create the form
        $form = $this->createForm(QuizType::class, $quiz);
    
        // Handle form submission if the request is POST
        $form->handleRequest($request);
    
        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle quiz creation
            $imageFile = $form['imageUrl']->getData();
    
            if ($imageFile) {
                // Handle image upload
                $newFilename = $this->uploadImage($imageFile, $slugger);
                $quiz->setImageUrl($newFilename);
            }
    
            // Persist the quiz entity
            $entityManager->persist($quiz);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_question_add', ['quiz' => $quiz1]);     
           }
    
        // Render the template with the form and Quiz data
        return $this->render('pages/user/quizAdd.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    private function uploadImage(UploadedFile $imageFile, SluggerInterface $slugger): string
    {
        $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename. '.' . $imageFile->guessExtension();
    
        try {
            // Move the file to the upload directory
            $imageFile->move(
                $this->getParameter('image_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            // Handle file upload exception if necessary
        }
    
        return $newFilename;
    }
    

    
    #[Route('/user/quizdelete/{id}', name: 'quiz_data_del')]

public function delete($id,EntityManagerInterface $entityManager, QuizRepository $quizRepository): Response
{
    $quiz=$quizRepository->find($id);

    $entityManager->remove($quiz);
    $entityManager->flush();
    dump($quiz);
    return $this->redirectToRoute('app_quiz_show');
}
#[Route('/user/quizmod/{id}', name: 'quiz_data_mod')]
public function modify($id, QuizRepository $quizRepository, Request $request, EntityManagerInterface $entityManagerInterface): Response
{
    $quiz = $quizRepository->find($id);
    $quiz1=$quiz;
    $form = $this->createForm(QuizType::class, $quiz);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle file upload for the image field
        $imageFile = $form['imageUrl']->getData();

        if ($imageFile instanceof UploadedFile) {
            // Generate a unique filename and move the uploaded file to the desired directory
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
$newFilename = $safeFilename.'.'.$imageFile->guessExtension();

            // Update the imageUrl property of the quiz entity with the new filename
            $quiz->setImageUrl($newFilename);
        }

        $entityManagerInterface->persist($quiz);
        $entityManagerInterface->flush();

        return $this->redirectToRoute("app_quiz_show");
    }

    return $this->render('pages/user/quizMod.html.twig', [
        'form' => $form->createView(),
        'quiz'=>$quiz1,
    ]);
}

#[Route('/user/quiz/{value}', name: 'app_quiz_search')]
public function searchQuiz($value, QuizRepository $quizRepository): Response
{
    $quizs = $quizRepository->searchQuiz($value);
    
    return $this->render('pages/user/quiz.html.twig', [
        'quizs' => $quizs,
    ]);
}

}
