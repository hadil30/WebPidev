<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function sendCertificationEmail(string $userEmail, string $pdfContent, MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('hadilhadjalouane13@gmail.com')
            ->to($userEmail)
            ->subject('Certification')
            ->text('Please find your certification attached.')
            ->attach($pdfContent, 'Certification.pdf');

        try {
            $mailer->send($email);
            return new Response('Email was sent');
        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
            error_log('Failed to send email: ' . $e->getMessage());
            throw new \RuntimeException('Could not send email: ' . $e->getMessage());
        }
    }
}
