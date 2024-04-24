<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Books;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class userController extends AbstractController
{
    #[Route('/user/profile', name: 'user_profile')]
    public function index(): Response
    {
        return $this->render('pages/user/profile.html.twig');
    }
    #[Route('/user/ebook', name: 'user_ebook', methods: ['GET'])]
    public function ebookdisplay(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        return $this->render('pages/user/ebooks.html.twig', [
            'b' => $books,
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

        // Créer une nouvelle entrée dans le panier avec les informations du livre
        $panier = new Panier();
        $panier->setNomLiv($bookTitle);
        $panier->setImagepath($bookImage);
        $panier->setTotalPrice($bookPrice); // Utiliser setPrixLiv() pour définir le prix du livre
        $panier->setPdfPath($bookPdfPath);

        // Obtenez le livre à partir de son ID et définissez-le dans le panier
        $livre = $this->getDoctrine()->getRepository(Books::class)->find($id);
        if (!$livre) {
            return new JsonResponse(['error' => 'Livre non trouvé'], Response::HTTP_NOT_FOUND);
        }
        $panier->setIdLiv($livre);

        // Sauvegarder le panier en base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($panier);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Livre ajouté au panier'], Response::HTTP_OK);
    }

}
