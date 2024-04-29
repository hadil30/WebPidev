<?php

namespace App\Repository;

use App\Entity\TestUtilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TestUtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestUtilisateur::class);
    }

    public function updateScore(int $user_id, int $id_Test, string $score): void
    {
        $entityManager = $this->getEntityManager();
        $testUtilisateur = $this->findOneBy(['user_id' => $user_id, 'id_Test' => $id_Test]);

        if ($testUtilisateur) {
            $testUtilisateur->setScore($score);
        } else {
            $testUtilisateur = new TestUtilisateur();
            $testUtilisateur->setUserId($user_id);
            $testUtilisateur->setTestId($id_Test);
            $testUtilisateur->setScore($score);
            $entityManager->persist($testUtilisateur);
        }

        $entityManager->flush();
    }
    public function createScore(int $user_id, int $id_Test, string $score): void
    {
        $entityManager = $this->getEntityManager();

        $testUtilisateur = $this->findOneBy(['user_id' => $user_id, 'id_Test' => $id_Test]);

        if (!$testUtilisateur) {
            $testUtilisateur = new TestUtilisateur();
            $testUtilisateur->setUserId($user_id);
            $testUtilisateur->setTestId($id_Test);
        }

        $testUtilisateur->setScore($score);
        $entityManager->persist($testUtilisateur);
        $entityManager->flush();
    }

    public function getHighestScoresByTest()
    {
        $entityManager = $this->getEntityManager();

        // First, get a subquery to find maximum scores for each testId
        $subQuery = $entityManager->createQueryBuilder()
            ->select('tu.id_Test as testId, MAX(tu.score) as maxScore')
            ->from('App\Entity\TestUtilisateur', 'tu')
            ->groupBy('tu.id_Test')
            ->getQuery()
            ->getScalarResult();

        // Array to hold final results with test names
        $results = [];

        // Now for each testId find the test name and construct the final result
        foreach ($subQuery as $item) {
            $test = $entityManager->getRepository('App\Entity\Test')
                ->find($item['testId']);

            if ($test) {
                $results[] = [
                    'testName' => $test->getNom(), // Assuming the Test entity has a method getNomTest()
                    'maxScore' => $item['maxScore']
                ];
            }
        }

        return $results;
    }
    public function findTakenStatusByUserId($userId)
    {
        $qb = $this->createQueryBuilder('tu')
            ->select('IDENTITY(tu.test) AS testId, 1 AS taken')
            ->where('tu.user = :userId')
            ->setParameter('userId', $userId);

        $result = $qb->getQuery()->getScalarResult();
        return array_column($result, 'taken', 'testId');
    }




    public function findScoreByTestIdAndUserId(int $testId, int $userId,): ?string
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT tu.score
             FROM App\Entity\TestUtilisateur tu
             WHERE tu.user_id = :userId AND tu.id_Test = :testId'
        )->setParameters([
            'userId' => $userId,
            'testId' => $testId,
        ]);

        // Execute the query and get one result or null, returned as scalar
        $result = $query->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_SINGLE_SCALAR);

        // If the result is null or the score isn't set, return null
        return $result ?: null;
    }
}
