<?php

namespace App\Repository;

use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    // Add custom repository methods here if needed
    public function searchQuiz($value): array
{
    return $this->createQueryBuilder('q')
        ->andWhere('q.quizId LIKE :val')  // Change 'exampleField' to the appropriate field
        ->orWhere('q.decrp LIKE :val')  // Add more fields as needed using OR conditions
        ->orWhere('q.titre LIKE :val')  // Add more fields as needed using OR conditions
        ->orWhere('q.nbQuest LIKE :val')  // Add more fields as needed using OR conditions
        ->orWhere('q.categorie LIKE :val')  // Add more fields as needed using OR conditions
        ->setParameter('val', '%' . $value . '%')  // Use wildcard (%) to search for partial matches
        ->getQuery()
        ->getResult();
}

}
