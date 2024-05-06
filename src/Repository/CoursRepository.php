<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }


    // Nouvelle méthode pour rechercher les cours par titre et niveau
    public function findByTitleAndLevel($title, $level)
    {
        $queryBuilder = $this->createQueryBuilder('c');
        
        // Si le titre est spécifié, ajoute une clause WHERE pour rechercher par titre
        if ($title) {
            $queryBuilder->andWhere('c.titre LIKE :title')
                         ->setParameter('title', '%'.$title.'%');
        }

        // Si le niveau est spécifié, ajoute une clause WHERE pour rechercher par niveau
        if ($level) {
            $queryBuilder->andWhere('c.niveau = :level')
                         ->setParameter('level', $level);
        }

        // Exécutez la requête et retournez les résultats
        return $queryBuilder->getQuery()->getResult();
    }

        // Exécutez la requête et retournez les résultats
        
    //    /**
    //     * @return CoursRepository[] Returns an array of CoursRepository objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Evenement
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    
}
