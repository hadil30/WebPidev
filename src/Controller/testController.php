<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\User;
use App\Repository\TestRepository;
use App\Repository\TestUtilisateurRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TestexecType;
use GuzzleHttp\Client;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Attachment;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use App\Controller\MailerController;

class testController extends AbstractController
{



    #[Route('/user/test', name: 'user_test')]
    public function index(Request $request, TestRepository $testRepository, TestUtilisateurRepository $testUtilisateurRepository): Response
    {
        //$user = $this->getUser(); 
        //$userId = $user->getUserId();
        $userId = 5;
        $searchQuery = $request->query->get('search');
        $categoryFilter = $request->query->get('category');
        $tests = [];

        if ($searchQuery) {
            $tests = $testRepository->searchByName($searchQuery);
        } elseif ($categoryFilter) {
            $tests = $testRepository->filterByCategory($categoryFilter);
        } else {
            $tests = $testRepository->findAll();
        }
        $tests = array_map(function ($test) use ($userId, $testUtilisateurRepository) {
            $testTaken = $testUtilisateurRepository->findOneBy(['user_id' => $userId, 'id_Test' => $test->getId()]);
            $test->taken = $testTaken ? true : false;
            return $test;
        }, $tests);

        return $this->render('pages/user/test.html.twig', [
            'tests' => $tests,
        ]);
    }

    private function calculateScore(Test $test, array $submittedResponses): float
    {
        $correctCount = 0;
        $totalQuestions = count($test->getQuestions());

        foreach ($test->getQuestions() as $question) {
            $correctResponseIds = [];
            foreach ($question->getReponses() as $response) {
                if ($response->getIsCorrect()) {
                    $correctResponseIds[] = $response->getIdReponse();
                }
            }

            $allCorrectSelected = true;
            foreach ($correctResponseIds as $responseId) {
                if (!in_array($responseId, $submittedResponses[$question->getIdQuestiont()] ?? [])) {
                    $allCorrectSelected = false;
                    break;
                }
            }

            $incorrectSelected = false;
            foreach ($submittedResponses[$question->getIdQuestiont()] ?? [] as $submittedResponseId) {
                if (!in_array($submittedResponseId, $correctResponseIds)) {
                    $incorrectSelected = true;
                    break;
                }
            }

            if ($allCorrectSelected && !$incorrectSelected) {
                $correctCount++;
            }
        }

        if ($totalQuestions > 0) {
            $scorePercentage = ($correctCount / $totalQuestions) * 100;
        } else {
            $scorePercentage = 0;
        }

        return $scorePercentage;
    }




    // #[Route('/user/test/exectest/{id}', name: 'test_exec', methods: ['GET', 'POST'])]
    /*public function testexec(Request $request, $id, EntityManagerInterface $entityManager, TestRepository $testRepository, TestUtilisateurRepository $TestUtilisateurRepository, UserRepository $userRepository): Response
    {
        $test = $testRepository->find($id);

        $canGetCertification = true;
        $remainingTime = $testRepository->getRemainingTime($test);


        if (!$test) {
            throw $this->createNotFoundException('The test does not exist');
        }

        if ($request->isMethod('POST')) {
            $submittedResponses = $request->request->get('responses', []);

            if (!is_array($submittedResponses)) {
                throw new \RuntimeException('Invalid format for submitted responses');
            }
            $score = $this->calculateScore($test, $submittedResponses);
            if ($score >= 70) {
                $canGetCertification = true;
                //  $user = $this->getUser();
                // $userEmail = $user->getEmail();
                $userEmail = "hadilha30@gmail.com";
            } else {
                $canGetCertification = false;
            }
            $TestUtilisateurRepository->createScore(5, $id, (string)$score);
            // $message = "heyy hadil, your score is $score ";
            // $userRepository->sms('+21699871426', $message);



            $this->addFlash('success', "Your score is: $score");
            return $this->redirectToRoute('test_exec', ['id' => $id]);
        }

        return $this->render('pages/user/execTest.html.twig', [
            'test' => $test,
            'remainingTime' => $remainingTime,
            'canGetCertification' => $canGetCertification,
            'userEmail' => $userEmail ?? null,

        ]);
    }*/
    #[Route('/user/test/exectest/{id}', name: 'test_exec', methods: ['GET', 'POST'])]
    public function testexec(Request $request, $id, EntityManagerInterface $entityManager, TestRepository $testRepository, TestUtilisateurRepository $testUtilisateurRepository, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $test = $testRepository->find($id);
        if (!$test) {
            throw $this->createNotFoundException('The test does not exist');
        }

        if ($request->isMethod('POST')) {
            $submittedResponses = $request->request->get('responses', []);
            if (!is_array($submittedResponses)) {
                throw new \RuntimeException('Invalid format for submitted responses');
            }

            $score = $this->calculateScore($test, $submittedResponses);
            $testUtilisateurRepository->createScore(5, $id, (string)$score);
            $this->addFlash('success', "Your score is: $score");


            return $this->redirectToRoute('test_exec', ['id' => $id]);
        }

        $remainingTime = $testRepository->getRemainingTime($test);

        return $this->render('pages/user/execTest.html.twig', [
            'test' => $test,
            'remainingTime' => $remainingTime,
        ]);
    }
    public function generateCertification(Request $request, $id, EntityManagerInterface $entityManager, TestUtilisateurRepository $testUtilisateurRepository, MailerInterface $mailer, MailerController $mailerController): Response
    {
        // Retrieve score
        $score = $testUtilisateurRepository->findScoreByTestIdAndUserId($id, 5);
        if (!$score || $score < 70) {
            return $this->json(['error' => 'Insufficient score or no score found', 'score' => $score], 400);
        }

        $recipientName = "Recipient Name";
        $testName = "Test Name";

        $certificationHtml = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Certificate of Achievement</title>
            <style>
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f5f5f5;
                    color: #333;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
                .certificate {
                    width: 90%;
                    height: 60%;
                    padding: 40px;
                    background-color: #fff;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    text-align: center;
                    border-radius: 8px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                }
                .certificate-logo {
                    max-width: 150px;
                    margin-bottom: 20px;
                }
                .certificate-title {
                    margin-bottom: 15px;
                    font-size: 32px;
                }
                .recipient, .test-name, .event, .score {
                    margin-bottom: 12px;
                }
                .signature, .date {
                    align-self: flex-end;
                    margin-right: 40px;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
        <div class="certificate">
            <img src="https://raw.githubusercontent.com/AhmeedGhoul/Na9ra-23-24-Pidev-/hadil/src/main/resources/gui/resources/logo.png" alt="Website Logo" class="certificate-logo"/>
            <div class="certificate-title">Certificate of Achievement</div>
            <div class="recipient">This certificate is awarded to $recipientName</div>
            <div class="test-name">For excellent performance in $testName</div>
            <div class="event">For achieving a score of:</div>
            <div class="score">$score</div>
            <div class="signature">Signature: NA9RA PLATFORM</div>
        </div>
        </body>
        </html>
        HTML;

        if ($this->generateAndSendCertification('hadilha30@gmail.com', $certificationHtml, $mailer, $mailerController)) {
            return $this->json(['message' => 'Certification sent successfully']);
        } else {
            return $this->json(['error' => 'Failed to send certification'], 500);
        }
    }

    private function generateAndSendCertification(string $userEmail, string $certificationHtml, MailerInterface $mailer, MailerController $mailerController): bool
    { {
            $client = new Client([
                'base_uri' => 'https://docraptor.com/docs',
                'auth' => ['RVq2A_y7_44Ss2QW-fEg', '']
            ]);

            try {
                $response = $client->post('', [
                    'form_params' => [
                        'doc[document_content]' => $certificationHtml,
                        'doc[document_type]' => 'pdf',
                    ]
                ]);

                if ($response->getStatusCode() === 200) {
                    $pdf = $response->getBody()->getContents();

                    $mailerController->sendCertificationEmail($userEmail, $pdf, $mailer);

                    return true;
                }
            } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
                return false;
            }

            return false;
        }
    }
}
