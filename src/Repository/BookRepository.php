<?php

namespace App\Repository;

use App\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Books::class);
    }

    public function findByTitleAndCategory($nomLiv, $categorieLiv)
    {
        $queryBuilder = $this->createQueryBuilder('b');

        if ($nomLiv) {
            $queryBuilder->andWhere('b.nomLiv LIKE :nomLiv')
                ->setParameter('nomLiv', '%' . $nomLiv . '%');
        }

        if ($categorieLiv) {
            $queryBuilder->andWhere('b.categorieLiv = :category')
                ->setParameter('category', $categorieLiv);
        }

        // Exécutez la requête et retournez les résultats
        return $queryBuilder->getQuery()->getResult();
    }



}
