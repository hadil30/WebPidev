<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TestQuestionRepository;

#[ORM\Table(name: "test_question", indexes: [
    [new ORM\Index(name: "id_Test", columns: ["id_Test"])],
    [new ORM\Index(name: "id_Questiont", columns: ["id_Questiont"])]
])]


#[ORM\Entity]
#[ORM\Table(name: "test_question")]
#[ORM\Entity(repositoryClass: TestQuestionRepository::class)]
class TestQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_test_question", type: "integer", nullable: false)]
    private int $idTestQuestion;

    #[ORM\ManyToOne(targetEntity: "Test")]
    #[ORM\JoinColumns([
        [new ORM\JoinColumn(name: "id_Test", referencedColumnName: "id_Test")]
    ])]
    private Test $idTest;

    #[ORM\ManyToOne(targetEntity: "Questiont")]
    #[ORM\JoinColumns([
        [new ORM\JoinColumn(name: "id_Questiont", referencedColumnName: "id_Questiont")]
    ])]
    private Questiont $idQuestiont;

    // Getters and setters
}
