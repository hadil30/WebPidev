<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "score", indexes: [new ORM\Index(name: "fk_quiz_idd", columns: ["quiz_id"])])]
class Score
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_score", type: "integer")]
    private int $idScore;

    #[ORM\Column(name: "score", type: "integer", nullable: true)]
    private ?int $score;

    #[ORM\Column(name: "datesc", type: "date", nullable: true)]
    private ?\DateTimeInterface $datesc;

    #[ORM\Column(name: "user_id", type: "integer", nullable: true)]
    private ?int $userId;

    #[ORM\ManyToOne(targetEntity: "Quiz")]
    #[ORM\JoinColumn(name: "quiz_id", referencedColumnName: "quiz_id")]
    private ?Quiz $quiz;

    // Getters and setters
}
