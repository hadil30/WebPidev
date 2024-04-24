<?php

namespace App\Controller;

use App\Entity\Books;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use App\Form\BookType;
use App\Form;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdminController extends AbstractController
{

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
    #[Route('/admin/test', name: 'admin_test')]
    public function test(): Response
    {
        return $this->render('pages/Admin/testadmin.html.twig');
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


    #[Route('/admin/ebook', name: 'admin_ebook', methods: ['GET'])]
    public function ebook(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        return $this->render('pages/Admin/ebookadmin.html.twig', [
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

            if ($imagePath instanceof UploadedFile) {
                $newFilename = uniqid() . '.' . $imagePath->guessExtension();
                $imagePath->move(
                    $this->getParameter('kernel.project_dir') . '/public/assets/',
                    $newFilename
                );
                $books->setImagePath($newFilename);
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

                // Mettre à jour l'attribut imagePath du livre avec le nouveau nom de fichier
                $book->setImagePath($newFilename);
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


}
