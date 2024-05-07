<?php

namespace App\Repository;

use App\Entity\Test;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class TestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Test::class);
    }
    public function searchByName($searchQuery)
    {
        return $this->createQueryBuilder('t')
            ->where('t.nom LIKE :search')
            ->setParameter('search', '%' . $searchQuery . '%')
            ->getQuery()
            ->getResult();
    }

    public function filterByCategory($categoryFilter)
    {
        return $this->createQueryBuilder('t')
            ->where('t.categorie = :category')
            ->setParameter('category', $categoryFilter)
            ->getQuery()
            ->getResult();
    }

    public function getRemainingTime(Test $test)
    {
        $endTime = $test->getTempPris();
        $now = new \DateTime("now");

        if ($endTime < $now) {
            return 0;
        }

        return $endTime->getTimestamp() - $now->getTimestamp();
    }

    public function getTotalNumberOfTests()
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('count(t.id)');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getNumberOfActiveTests()
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->where('t.status = :active')
            ->setParameter('active', 'active')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getNumberOfInactiveTests()
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->where('t.status = :inactive')
            ->setParameter('inactive', 'inactive')
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function calculateAverageQuestionsPerTest()
    {
        // Create QueryBuilder instance
        $qb = $this->createQueryBuilder('t');

        // Select the test ID and the count of questions per test
        $qb->select('t.id, COUNT(q.idQuestiont) AS questionCount')
            ->leftJoin('t.questions', 'q')  // Assuming 'questions' is the correct field name
            ->groupBy('t.id');

        // Execute the query to get number of questions per test
        $results = $qb->getQuery()->getResult();

        // Calculate the average number of questions
        $totalQuestions = 0;
        $testCount = count($results);
        foreach ($results as $result) {
            $totalQuestions += $result['questionCount'];
        }
        $average = $testCount > 0 ? $totalQuestions / $testCount : 0;

        return $average;
    }
    public function calculateAverageDuration()
    {
        $tests = $this->createQueryBuilder('t')
            ->select('t.tempPris')
            ->getQuery()
            ->getResult();

        $totalMinutes = 0;
        $count = count($tests);

        foreach ($tests as $test) {
            $formattedDate = $test['tempPris']->format('H i');
            $parts = explode(' ', $formattedDate);
            $hours = intval($parts[0]);
            $minutes = intval($parts[1]);

            $totalMinutes += $hours * 60 + $minutes;
        }

        return $count > 0 ? $totalMinutes / $count : 0;
    }
}
