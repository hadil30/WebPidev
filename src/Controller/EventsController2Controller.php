<?php

namespace App\Controller;

use App\Entity\Events;
use App\Form\EventsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/events/controller2')]
class EventsController2Controller extends AbstractController
{
    #[Route('/', name: 'app_events_controller2_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $events = $entityManager
            ->getRepository(Events::class)
            ->findAll();

        return $this->render('events_controller2/eventadmin.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/new', name: 'app_events_controller2_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_events_controller2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('events_controller2/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{eventId}', name: 'app_events_controller2_show', methods: ['GET'])]
    public function show(Events $event): Response
    {
        return $this->render('events_controller2/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/{eventId}/edit', name: 'app_events_controller2_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Events $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_events_controller2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('events_controller2/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{eventId}', name: 'app_events_controller2_delete', methods: ['POST'])]
    public function delete(Request $request, Events $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getEventId(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_events_controller2_index', [], Response::HTTP_SEE_OTHER);
    }
}
