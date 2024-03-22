<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "question", indexes: [new ORM\Index(name: "fk_quiz_id", columns: ["quiz_id"])])]
class Question
{
    #[ORM\Id]
    #[ORM\Column(name: "id_quest", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idQuest = null;

    #[ORM\Column(name: "quest", type: "string", length: 255, nullable: true)]
    private ?string $quest = null;

    #[ORM\Column(name: "rep1", type: "string", length: 255)]
    private string $rep1;

    #[ORM\Column(name: "rep2", type: "string", length: 255)]
    private string $rep2;

    #[ORM\Column(name: "rep3", type: "string", length: 255)]
    private string $rep3;

    #[ORM\Column(name: "rep4", type: "string", length: 255)]
    private string $rep4;

    #[ORM\Column(name: "repc", type: "string", length: 255)]
    private string $repc;

    #[ORM\ManyToOne(targetEntity: Quiz::class)]
    #[ORM\JoinColumn(name: "quiz_id", referencedColumnName: "quiz_id")]
    private ?Quiz $quiz = null;

    // Getters and setters
}
