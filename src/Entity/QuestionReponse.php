<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "question_reponse", indexes: [
    new ORM\Index(name: "id_Reponse", columns: ["id_Reponse"]),
    new ORM\Index(name: "id_Questiont", columns: ["id_Questiont"])
])]
class QuestionReponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "question_reponse", type: "integer")]
    private ?int $questionReponse = null;

    #[ORM\ManyToOne(targetEntity: Questiont::class)]
    #[ORM\JoinColumn(name: "id_Questiont", referencedColumnName: "id_Questiont")]
    private ?Questiont $idQuestiont = null;

    #[ORM\ManyToOne(targetEntity: Reponse::class)]
    #[ORM\JoinColumn(name: "id_Reponse", referencedColumnName: "id_Reponse")]
    private ?Reponse $idReponse = null;

    // Getters and setters
}
