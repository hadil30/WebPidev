<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]

    public function indexlogin(Request $request): Response
    {
        $form = $this->createForm(LoginFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Directly check the request for which button was clicked
            $submittedData = $request->request->get($form->getName());

            // Check if the submit1 or submit2 button was clicked based on their presence in the submitted data
            if (isset($submittedData['submit1'])) {
                // Logic for submit1 button
                return $this->redirectToRoute('user');
            } elseif (isset($submittedData['submit2'])) {
                // Logic for submit2 button
                return $this->redirectToRoute('admin');
            }
        }

        return $this->render('pages/Interface_Communes/Login.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/user', name: 'user')]
    public function indexUser(): Response
    {
        return $this->render('pages/Interface_Communes/userinterface.html.twig', []);
    }

    #[Route('/admin', name: 'admin')]
    public function indexadmin(): Response
    {
        return $this->render('pages/Admin/admindashboard.html.twig', []);
    }
}
