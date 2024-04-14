<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CoursRepository;
use App\Entity\Cours;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CoursType;
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


    #[Route('/admin/cours', name: 'admin_cours',methods: ['GET'])]
    public function cours(CoursRepository $coursRepository): Response
    {
        $cours = $coursRepository->findAll();
       
        return $this->render('pages/Admin/coursadmin.html.twig', [
            'l' => $cours,
        ]); 
    }
    
   
   /*#[Route('/admin/cours/add', name: 'admin_coursadd')]
public function newcours(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
{
    dump('La méthode newcours() est appelée.');

    $cours = new Cours();
    $form = $this->createForm(CoursType::class, $cours);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($cours);
        $entityManager->flush();

        $this->addFlash('success', 'Cours created successfully.');

        return $this->redirectToRoute('admin_cours');
    }

    return $this->render('pages/Admin/addCoursadmin.html.twig', [
        'form' => $form->createView(),
        'l' => $this->getDoctrine()->getRepository(Cours::class)->findAll(), // Ajout de la variable 'l'
    ]);
}*/
/*#[Route('/admin/cours/add', name: 'admin_coursadd')]
public function newcours(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
{
        $cours = new Cours();
        $form = $this ->createForm(CoursType::class,$cours);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $ImagePath = $form->get('ImagePath')->getData(); 

            if ($ImagePath instanceof UploadedFile) {
                $newFilename = uniqid().'.'.$ImagePath->guessExtension();
                $ImagePath->move(
                    $this->getParameter('kernel.project_dir').'/public/assets/',
                    $newFilename
                );
                $cours->setImagePath($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($cours);
            $em->flush();
            return $this->redirectToRoute('admin_cours');
        }
        return $this->render('pages/Admin/addCoursadmin.html.twig', ['l' => $form->createView()]);

}*/
#[Route('/admin/cours/add', name: 'admin_coursadd')]
public function newcours(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
{
   $cours = new Cours();
   $form = $this ->createForm(CoursType::class,$cours);
   $form->handleRequest($request);
   if($form->isSubmitted() && $form->isValid()){
       $ImagePath = $form->get('ImagePath')->getData(); 

       if ($ImagePath instanceof UploadedFile) {
           $newFilename = uniqid().'.'.$ImagePath->guessExtension();
           $ImagePath->move(
               $this->getParameter('kernel.project_dir').'/public/assets/',
               $newFilename
           );
           $cours->setImagePath($newFilename);
       }
       $em = $this->getDoctrine()->getManager();
       $em->persist($cours);
       $em->flush();
       return $this->redirectToRoute('admin_cours');
   }
   return $this->render('pages/Admin/addCoursadmin.html.twig', ['l' => $form->createView()]);

}  






    #[Route('/admin/cours/update', name: 'admin_coursupdate')]

    public function updatecours(CoursRepository $coursRepository): Response
    {
        $cours = $coursRepository->findAll();


        return $this->render('pages/Admin/updateCoursAdmin.html.twig', [
            'l' => $cours,
        ]);
    }

    

    /*#[Route('/admin/cours/update/{id}', name: 'cours_detail')]
    public function coursDetail(Request $request, $id, EntityManagerInterface $entityManager,): Response
    {
        $cours = $this->getDoctrine()->getRepository(Cours::class)->find($id);

        if (!$cours) {
            throw $this->createNotFoundException('The course does not exist');
        }

        $form = $this->createForm(CoursType::class, $cours);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cours);
            $entityManager->flush();

            $this->addFlash('success', 'Cours updated successfully.');

            return $this->redirectToRoute('admin_cours');
        }

        return $this->render('pages/Admin/detailcours.html.twig', [
            'form' => $form->createView(),
            'l' => $cours,
        ]);
    }*/

    #[Route('/admin/cours/update/{id}', name: 'cours_detail')]
    public function coursDetail(Request $request, $id, EntityManagerInterface $entityManager): Response
{
    $cours = $this->getDoctrine()->getRepository(Cours::class)->find($id);

    if (!$cours) {
        throw $this->createNotFoundException('The course does not exist');
    }

    $form = $this->createForm(CoursType::class, $cours);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // Récupérer la nouvelle image
        $imageFile = $form->get('ImagePath')->getData();
        
        if ($imageFile) {
            // Gérer le téléchargement de la nouvelle image
            $newFilename = uniqid().'.'.$imageFile->guessExtension();
            
            // Déplacez le fichier dans le répertoire où sont stockées les images des livres
            $imageFile->move(
                $this->getParameter('cours_images_directory'),
                $newFilename
            );

            // Mettre à jour l'attribut imagePath du livre avec le nouveau nom de fichier
            $cours->setImagePath($newFilename);
        }

        // Enregistrer les modifications dans la base de données
        $entityManager->flush();

        $this->addFlash('success', 'Course updated successfully.');

        return $this->redirectToRoute('admin_cours');
    }

    return $this->render('pages/Admin/detailcours.html.twig', [
        'form' => $form->createView(),
        'l' => $cours,
    ]);
}


    #[Route('/admin/cours/delete/{id}', name: 'cours_delete')]

    public function deleteCours(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $cours = $entityManager->getRepository(Cours::class)->find($id);

        if (!$cours) {
            throw $this->createNotFoundException('No cours found for id ' . $id);
        }

        $entityManager->remove($cours);
        $entityManager->flush();

        $this->addFlash('success', 'Cours successfully deleted.');

        return $this->redirectToRoute('admin_cours'); // Redirect to the route where you list the cours
    }



   

}
