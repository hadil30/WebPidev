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
    public function quizAdd(Request $request, QuizRepository $quizRepository, EntityManagerInterface $entityManager): Response
    {
        // Create a new Quiz instance
        $quiz = new Quiz();
       
        // Create the form
        $form = $this->createForm(QuizType::class, $quiz);
    
        // Handle form submission if the request is POST
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
    
            // Check if the form is submitted and valid
            if ($form->isSubmitted() && $form->isValid()) {
                $imageFile = $form['imageUrl']->getData();
                if ($imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $this->slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                
                    try {
                        // Move the file to the upload directory
                        $imageFile->move(
                            $this->getParameter('image_directory'),
                            $newFilename
                        );
        
                        // Set the image URL property of the Quiz entity
                        $quiz->setImageUrl($newFilename);
                    } catch (FileException $e) {
                        // Handle file upload exception if necessary
                    }
                }
                // Persist the quiz entity
                $entityManager->persist($quiz);
                $entityManager->flush();
               
                // Redirect to a success page or do any other actions
                return $this->redirectToRoute('app_quiz_show');
            }
        }
    

    
        // Render the template with the form and Quizs data
        return $this->render('pages/user/quizAdd.html.twig', [
            'form' => $form->createView(),
        ]);
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
    $form = $this->createForm(QuizType::class, $quiz);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle file upload for the image field
        $imageFile = $form['imageUrl']->getData();

        if ($imageFile instanceof UploadedFile) {
            // Generate a unique filename and move the uploaded file to the desired directory
            $newFilename = uniqid().'.'.$imageFile->guessExtension();
            $imageFile->move($this->getParameter('image_directory'), $newFilename);

            // Update the imageUrl property of the quiz entity with the new filename
            $quiz->setImageUrl($newFilename);
        }

        $entityManagerInterface->persist($quiz);
        $entityManagerInterface->flush();

        return $this->redirectToRoute("app_quiz_show");
    }

    return $this->render('pages/user/quizMod.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/user/quiz/{value}', name: 'app_quiz_search')]

#[Route('/user/quiz/{value}', name: 'app_quiz_search')]
public function searchQuiz($value, QuizRepository $quizRepository): Response
{
    $quizs = $quizRepository->searchQuiz($value);
    
    return $this->render('pages/user/quiz.html.twig', [
        'quizs' => $quizs,
    ]);
}

}
