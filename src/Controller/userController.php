<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UserFormType;
use App\Form\UsereditType;
use App\Form\UsereditprofilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;


class userController extends AbstractController
{
    #[Route('/user/profile', name: 'user_profile')]
    public function index(): Response
    {
        return $this->render('pages/user/profile.html.twig');
    }

    #[Route('/user/view', name: 'app_user_view')]
    public function view(UserRepository $UserRepository): Response
    {
        $users = $UserRepository->findAll();
        return $this->render('pages/Admin/useradmin.html.twig', ['users' => $users]);
    }


    #[Route('/user/delete/{id}', name: 'app_user_delete')]
    public function delete(int $id, Request $request, UserRepository $UserRepository): Response
    {
        
        $user = $UserRepository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('app_user_view');
    }



    #[Route('/user/count', name: 'app_user_count')]
    public function nombreUtilisateurs(UserRepository $userRepository): Response
    {
        // Compter le nombre d'utilisateurs
        $nombreUtilisateurs = $userRepository->createQueryBuilder('u')
            ->select('COUNT(u.userId)')
            ->getQuery()
            ->getSingleScalarResult();

        // Passer le nombre d'utilisateurs au template
        return $this->render('pages/Admin/useradmin.html.twig', [
            'nbuser' => $nombreUtilisateurs,
        ]);
    }

    #[Route('/user/addd', name: 'app_user_addd')]
    public function Add(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $User = new User();
        $form = $this->createForm(UserFormType::class, $User);
        //$form->add('ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $image = $form->get('image')->getData();
            if ($image) // ajout image
            {
                $fileName = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move($this->getParameter('files_directory'), $fileName);
                $User->setImage($fileName);
            } else {

                $User->setImage("bb3faeefbe0d47b7d651c7e551fef7e0.png");
            }

            $User->setPassword($passwordEncoder->encodePassword($User, $User->getPassword()));
            $em->persist($User);
            $em->flush();
            return $this->redirectToRoute('app_loginn');
        }
        return $this->render('pages/Interface_Communes/singup.html.twig', ['h' => $form->createView()]);
    }

    #[Route('/user/edit/{id}', name: 'app_user_edit')]
    public function edit($id, Request $request, UserRepository $UserRepository, UserPasswordEncoderInterface $passwordEncoder)
    {

        $user = $UserRepository->find($id);

        $form = $this->createForm(UsereditType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_user_view');
        }
        return $this->renderForm('pages/Admin/edit.html.twig', ['h' => $form, 'title' => 'edit user', 'user' => $user]);
    }
    #[Route('/user/editprofil/{id}', name: 'app_user_profil')]
    public function editprofil($id, Request $request, UserRepository $UserRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $UserRepository->find($id);
        $form = $this->createForm(UsereditprofilType ::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->renderForm('pages/user/profil.html.twig', ['h' => $form, 'title' => 'edit user', 'user' => $user]);
    }
    
 #[Route('/user/search', name: 'app_user_search')]
    public function searchUser(Request $request, UserRepository $repository): Response
    {
        $query = $request->request->get('query');
        $users = $repository->searchByNom($query);
        return $this->render('pages/Admin/search.html.twig', [
            'users' => $users
        ]);
    }
}
