<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Cache\SymfonyCache;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class BotManController extends AbstractController
{
    #[Route('/botman/chat', name: 'chatbot', methods: ['POST', 'GET'])]
    public function handle(Request $request): Response
    {
        // Extract request data
        $requestData = json_decode($request->getContent(), true);

        // Your BotMan configuration
        $config = [
            'web' => [
                'matchingData' => [
                    'driver' => 'web',
                ],
            ]
        ];

        // Load the web driver
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        // Create Symfony Cache Adapter
        $adapter = new FilesystemAdapter();

        // Create BotMan instance with Symfony Cache
        $botman = BotManFactory::create($config, new SymfonyCache($adapter));

        // Give the bot something to listen for.
        $botman->hears('hello', function (BotMan $bot) {
            $bot->reply('Hello yourself.');
        });

        // Handle incoming message
        $botman->listen();

        // Return a response
        return new Response();
    }
}
