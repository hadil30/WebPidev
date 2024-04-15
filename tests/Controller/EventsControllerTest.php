<?php

namespace App\Test\Controller;

use App\Entity\Events;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/events/controller2/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Events::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Event index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'event[nom]' => 'Testing',
            'event[description]' => 'Testing',
            'event[typee]' => 'Testing',
            'event[datee]' => 'Testing',
            'event[status]' => 'Testing',
            'event[imageUrl]' => 'Testing',
            'event[user]' => 'Testing',
            'event[feedback]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Events();
        $fixture->setNom('My Title');
        $fixture->setDescription('My Title');
        $fixture->setTypee('My Title');
        $fixture->setDatee('My Title');
        $fixture->setStatus('My Title');
        $fixture->setImageUrl('My Title');
        $fixture->setUser('My Title');
        $fixture->setFeedback('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Event');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Events();
        $fixture->setNom('Value');
        $fixture->setDescription('Value');
        $fixture->setTypee('Value');
        $fixture->setDatee('Value');
        $fixture->setStatus('Value');
        $fixture->setImageUrl('Value');
        $fixture->setUser('Value');
        $fixture->setFeedback('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'event[nom]' => 'Something New',
            'event[description]' => 'Something New',
            'event[typee]' => 'Something New',
            'event[datee]' => 'Something New',
            'event[status]' => 'Something New',
            'event[imageUrl]' => 'Something New',
            'event[user]' => 'Something New',
            'event[feedback]' => 'Something New',
        ]);

        self::assertResponseRedirects('/events/controller2/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getTypee());
        self::assertSame('Something New', $fixture[0]->getDatee());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getImageUrl());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getFeedback());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Events();
        $fixture->setNom('Value');
        $fixture->setDescription('Value');
        $fixture->setTypee('Value');
        $fixture->setDatee('Value');
        $fixture->setStatus('Value');
        $fixture->setImageUrl('Value');
        $fixture->setUser('Value');
        $fixture->setFeedback('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/events/controller2/');
        self::assertSame(0, $this->repository->count([]));
    }
}
