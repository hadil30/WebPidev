<?php

namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Books;

use App\Entity\Questiont;
use App\Entity\Test;
use App\Repository\TestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use App\Form\BookType;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    // #[Route('/admin/ebook', name: 'admin_ebook', methods: ['GET'])]
    // public function ebook(BookRepository $bookRepository): Response
    // {
    //     $books = $bookRepository->findAll();
    //     return $this->render('pages/Admin/ebookadmin.html.twig', ['l' => $books,]);
    // }
    #[Route('/admin/ebook', name: 'admin_ebook', methods: ['GET'])]
    public function ebook(Request $request, BookRepository $bookRepository, PaginatorInterface $paginator): Response
    {
        $books = $bookRepository->findAll();

        // Query to fetch all books
        $query = $bookRepository->createQueryBuilder('b')
            ->getQuery();
        if ($request->query->getInt('page', 1) === 1) {
            $query->setMaxResults(3);
        }

        // Paginate the query
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Get the page number from the request, default to 1 if not set
            3 // Number of items per page
        );

        // Render the template with pagination data
        return $this->render('pages/Admin/ebookadmin.html.twig', [
            'pagination' => $pagination,
            'l' => $books,
        ]);
    }

    #[Route('/admin/ebook/add', name: 'admin_ebookadd')]
    public function newbook(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $books = new Books();
        $form = $this->createForm(BookType::class, $books);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imagePath = $form->get('imagePath')->getData(); // Utilisez imagePath au lieu de ImagePath
            $pdfPath = $form->get('pdfPath')->getData(); // Utilisez imagePath au lieu de ImagePath

            if ($imagePath instanceof UploadedFile) {
                $newFilename = uniqid() . '.' . $imagePath->guessExtension();
                $imagePath->move(
                    $this->getParameter('kernel.project_dir') . '/public/assets/',
                    $newFilename
                );
                $books->setImagePath($newFilename);
            }
            if ($pdfPath instanceof UploadedFile) {
                $newFilename2 = uniqid() . '.' . $pdfPath->guessExtension();
                $pdfPath->move(
                    $this->getParameter('kernel.project_dir') . '/public/assets/',
                    $newFilename2
                );
                $books->setPdfPath($newFilename2);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($books);
            $em->flush();
            return $this->redirectToRoute('admin_ebook');
        }
        $errors = $form->getErrors(true);
        return $this->render('pages/Admin/addbook.html.twig', [
            'l' => $form->createView(),
            'errors' => $errors
        ]);

    }




    #[Route('/admin/books/update/{id}', name: 'books_detail')]
    public function booksDetail(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $book = $this->getDoctrine()->getRepository(Books::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException('The book does not exist');
        }

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer la nouvelle image
            $imageFile = $form->get('imagePath')->getData();

            if ($imageFile) {
                // Gérer le téléchargement de la nouvelle image
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                // Déplacez le fichier dans le répertoire où sont stockées les images des livres
                $imageFile->move(
                    $this->getParameter('books_images_directory'),
                    $newFilename
                );









                $pdfFile = $form->get('pdfPath')->getData();

                if ($pdfFile) {
                    // Gérer le téléchargement de la nouvelle image
                    $newFilename2 = uniqid() . '.' . $pdfFile->guessExtension();

                    // Déplacez le fichier dans le répertoire où sont stockées les images des livres
                    $imageFile->move(
                        $this->getParameter('books_images_directory'),
                        $newFilename2
                    );




                    // Mettre à jour l'attribut imagePath du livre avec le nouveau nom de fichier
                    $book->setImagePath($newFilename);
                    $book->setImagePath($newFilename2);

                }

                // Enregistrer les modifications dans la base de données
                $entityManager->flush();

                $this->addFlash('success', 'Book updated successfully.');

                return $this->redirectToRoute('admin_ebook');
            }

            return $this->render('pages/Admin/detailbooks.html.twig', [
                'form' => $form->createView(),
                'book' => $book,
            ]);
        }

    }
    #[Route('/admin/book/delete/{id}', name: 'books_delete')]

    public function deleteBooks(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $books = $entityManager->getRepository(Books::class)->find($id);

        if (!$books) {
            throw $this->createNotFoundException('No Book found for id ' . $id);
        }

        $entityManager->remove($books);
        $entityManager->flush();

        $this->addFlash('success', 'Book successfully deleted.');

        return $this->redirectToRoute('admin_ebook'); // Redirect to the route where you list the cours
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
