<?php

namespace App\Controller;

use App\Entity\Test;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\CoursRepository;
use App\Entity\Cours;
use App\Entity\Discussion;
use Symfony\Component\HttpFoundation\Request; // Import de la classe Request
use App\Repository\DiscussionRepository;

class userController extends AbstractController
{
    #[Route('/user/profile', name: 'user_profile')]
    public function index(): Response
    {
        return $this->render('pages/user/profile.html.twig');
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
