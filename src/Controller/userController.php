<?php

namespace App\Controller;

use App\Entity\Test;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Panier;
use App\Entity\Books;
use App\Entity\User;
use App\Repository\BookRepository;
use App\Repository\CollectionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Stripe\Stripe;
use Stripe\Charge;
use App\Repository\CoursRepository;
use App\Entity\Cours;
use App\Entity\Discussion;
use App\Repository\DiscussionRepository;

class userController extends AbstractController
{


    #[Route('/user/profile', name: 'user_profile')]
    public function index(): Response
    {
        return $this->render('pages/user/profile.html.twig');
    }
    #[Route('/user/ebook', name: 'user_ebook', methods: ['GET'])]
    public function ebookdisplay(Request $request, BookRepository $bookRepository, PaginatorInterface $paginator): Response
    {

        // Query to fetch all books
        $query = $bookRepository->createQueryBuilder('b')
            ->getQuery();
        if ($request->query->getInt('page', 1) === 1) {
            $query->setMaxResults(4);
        }

        // Paginate the query
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Get the page number from the request, default to 1 if not set
            4 // Number of items per page
        );

        // Render the template with pagination data
        return $this->render('pages/user/ebooks.html.twig', [
            'pagination' => $pagination,

        ]);
    }

    #[Route("/add-to-cart/{id}", name: "add_to_cart")]
    public function addToCart(Request $request, $id): JsonResponse
    {
        // Récupérer les informations du livre à partir de la requête
        $bookTitle = $request->request->get('NomLiv');
        $bookImage = $request->request->get('ImagePath');
        $bookPrice = $request->request->get('PrixLiv');
        $bookPdfPath = $request->request->get('PdfPath');
        $entityManager = $this->getDoctrine()->getManager();

        $iduser = $entityManager->getRepository(User::class)->find(5);
        // Créer une nouvelle entrée dans le panier avec les informations du livre
        $panier = new Panier();
        $panier->setNomLiv($bookTitle);
        $panier->setImagepath($bookImage);
        $panier->setTotalPrice($bookPrice);
        // Utiliser setPrixLiv() pour définir le prix du livre
        $panier->setPdfPath($bookPdfPath);
        $panier->setIduser($iduser);


        // Obtenez le livre à partir de son ID et définissez-le dans le panier
        $livre = $this->getDoctrine()->getRepository(Books::class)->find($id);
        if (!$livre) {
            return new JsonResponse(['error' => 'Livre non trouvé'], Response::HTTP_NOT_FOUND);
        }
        $panier->setIdLiv($livre);

        // Sauvegarder le panier en base de données
        $entityManager->persist($panier);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Livre ajouté au panier'], Response::HTTP_OK);
    }
    #[Route('/user/collection', name: 'user_collection', methods: ['GET'])]
    public function collectiondisplay(CollectionRepository $CollectionRepository): Response
    {
        $panier = $CollectionRepository->findAll();
        return $this->render('pages/user/collection.html.twig', [
            'p' => $panier,
        ]);
    }
    #[Route('/user/collection/delete/{id}', name: 'collection_delete')]

    public function deletecollection(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $collection = $entityManager->getRepository(Panier::class)->find($id);

        if (!$collection) {
            throw $this->createNotFoundException('No Book found for id ' . $id);
        }

        $entityManager->remove($collection);
        $entityManager->flush();

        $this->addFlash('success', 'Book successfully deleted.');

        return $this->redirectToRoute('user_collection'); // Redirect to the route where you list the cours
    }

    #[Route('/user/collection/pdf', name: 'collection_pdf')]
    public function generatecollectionsPdf(CollectionRepository $collectionRepository): Response
    {
        // Récupérer tous les cours et leurs discussions associées
        $collection = $collectionRepository->findAll();

        // Créer le HTML pour le contenu du PDF
        $html = $this->renderView('pages/user/pdf.html.twig', [
            'collection' => $collection,
        ]);

        // Chemin du fichier de sortie PDF
        $outputFile = 'Collection.pdf';

        // Chemin du répertoire contenant les images
        $imageDirectory = 'C:/Users/rannn/Desktop/WebPidev - Copie (2)/public/assets';

        // Construire la commande pour wkhtmltopdf avec les options
        $command = [
            'C:/Program Files/wkhtmltopdf/bin/wkhtmltopdf.exe',
            '--allow',
            $imageDirectory, // Autoriser l'accès aux images
            '--margin-bottom',
            '10',
            '--margin-top',
            '10',
            '--margin-left',
            '10',
            '--margin-right',
            '10',
            '-', // Utilisation de '-' pour indiquer que l'entrée vient de stdin
            $outputFile, // Le fichier de sortie PDF
        ];

        // Exécuter la commande avec le HTML en entrée
        $process = new Process($command);
        $process->setInput($html);
        $process->run();

        // Vérifier si la commande s'est exécutée avec succès
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Retourner le contenu du PDF en réponse HTTP
        return new Response(
            file_get_contents($outputFile),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Collection.pdf"',
            ]
        );
    }





    #[Route('/user/stripe/create-charge/{idPanier}', name: 'app_stripe_charge', methods: ['POST'])]
    public function createCharge(
        Request $request,
        EntityManagerInterface $entityManager,
        CollectionRepository $CollectionRepository,
        $idPanier
    ) {
        // Fetch user ID from session or wherever it's available
        $userId = 4;

        // Fetch the user object using the user ID
        $user = $this->getDoctrine()->getRepository(User::class)->find($userId);

        if (!$user) {
            // Handle the case where the user is not found
            return new Response('User not found.', Response::HTTP_NOT_FOUND);
        }



        // Fetch the panier object using the panier ID
        $panier = $CollectionRepository->find($idPanier);

        if (!$panier) {
            // Handle the case where the panier is not found
            return new Response('Panier not found.', Response::HTTP_NOT_FOUND);
        }

        // Get the book associated with the panier
        $book = $panier->getIdLiv();
        if (!$book) {
            // Handle the case where the associated book is not found
            return new Response('Book not found in the panier.', Response::HTTP_NOT_FOUND);
        }

        // Get necessary details for creating the charge
        $userName = $user->getNom();
        $bookName = $panier->getNomLiv();
        $bookPrice = $panier->getTotalPrice();

        // Set up Stripe
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
        try {
            // Create a charge using Stripe API
            Charge::create([
                "amount" => $bookPrice * 100, // Convert to cents
                "currency" => "usd",
                "source" => $request->request->get('stripeToken'),
                "description" => "Payment for the book: $bookName ",
                "metadata" => [
                    "user_name" => $userName,
                    "book_name" => $bookName,
                    "book_price" => $bookPrice
                ]
            ]);

            // Flash success message
            $this->addFlash('success', 'Payment successful!');

            // Remove the panier from the database
            $entityManager->remove($panier);
            $entityManager->flush();

            // Redirect to user's collection page or any other page
            return $this->redirectToRoute('user_collection');
        } catch (\Exception $e) {
            // Log and flash error message
            error_log("Error creating charge: " . $e->getMessage());
            $this->addFlash('error', 'Error processing payment!');
            return $this->redirectToRoute('user_collection');
        }
    }
    #[Route('/user/collection/payment/{idPanier}', name: 'payment')]
    public function payment(EntityManagerInterface $entityManager, $idPanier): Response
    {
        // Fetch the Panier entity from the database
        $panier = $entityManager->getRepository(Panier::class)->find($idPanier);
        $stripeKey = $_ENV['pubkey'];

        // Ensure $panier is not null and contains the idPanier attribute
        if ($panier && $panier->getIdPanier()) {
            // Pass the $panier object to the template
            return $this->render('pages/user/payment.html.twig', [
                'panier' => $panier,
                'totalPrice' => $panier->getTotalPrice(),
                'stripe_key' => $stripeKey, // Pass the totalPrice property
            ]);
        } else {
            // Handle the case where the Panier entity or idPanier is not available
            throw $this->createNotFoundException('Panier not found.');
        }
    }

    #[Route('/user/collection/download-pdf/{idPanier}', name: 'download_pdf')]
    public function downloadpdfaction($idPanier, EntityManagerInterface $entityManager): Response
    {
        // Fetch the Panier entity from the database
        $panier = $entityManager->getRepository(Panier::class)->find($idPanier);

        if (!$panier) {
            throw $this->createNotFoundException('Panier not found.');
        }

        // Get the PDF path from the Panier entity
        $pdfPath = 'C:/Users/rannn/Desktop/WebPidev - Copie (2)/public/assets/' . $panier->getPdfpath();
        // Check if the PDF path exists
        if (!file_exists($pdfPath)) {
            throw $this->createNotFoundException('PDF file not found.');
        }

        // Create a BinaryFileResponse to trigger the file download
        $response = new BinaryFileResponse($pdfPath);

        // Set the response headers for downloading the file
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            basename($pdfPath)
        );

        return $response;
    }





    #[Route('/user/cours', name: 'user_cours')]
    public function cours(CoursRepository $coursRepository): Response
    {
        $cours = $coursRepository->findAll();

        return $this->render('pages/user/cours.html.twig', [
            'cours' => $cours,
        ]);
    }

    #[Route('/cours/{id}', name: 'detaile_cours')]
    public function detaileCours(int $id, CoursRepository $coursRepository, DiscussionRepository $discussionRepository, Request $request): Response
    {
        $cours = $coursRepository->find($id);
        if (!$cours) {
            throw $this->createNotFoundException('Le cours demandé n\'existe pas.');
        }

        // Récupérer les commentaires
        $commentaires = $discussionRepository->findBy(['idCours' => $id]);

        // Fixer l'ID de l'utilisateur à 1 pour afficher les boutons de modification et de suppression
        $idUserWithButtons = 1;

        return $this->render('pages/user/cours_details.html.twig', [
            'cours' => $cours,
            'commentaires' => $commentaires,
            'idUserWithButtons' => $idUserWithButtons,
        ]);
    }

    #[Route('/cours/{id}/commentaire/ajouter', name: 'ajouter_commentaire', methods: ['POST'])]
    public function ajouterCommentaire(int $id, Request $request, DiscussionRepository $discussionRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cours = $entityManager->getRepository(Cours::class)->find($id);

        if (!$cours) {
            throw $this->createNotFoundException('Le cours demandé n\'existe pas.');
        }

        $user = $this->getUser();
        $nouveauCommentaire = $request->request->get('commentaire');

        $discussion = new Discussion();
        $discussion->setUser($user);
        $discussion->setMessage($nouveauCommentaire);
        $discussion->setIdCours($cours);

        $entityManager->persist($discussion);
        $entityManager->flush();

        return $this->redirectToRoute('detaile_cours', ['id' => $id]);
    }
}
