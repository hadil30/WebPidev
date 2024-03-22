<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuestiontRepository;

#[ORM\Entity]
#[ORM\Table(name: "questiont")]
#[ORM\Entity(repositoryClass: QuestiontRepository::class)]

class Questiont
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_Questiont", type: "integer")]
    private ?int $idQuestiont = null;

    #[ORM\Column(name: "text", type: "text", nullable: true)]
    private ?string $text = null;

    // Getters and setters
}
