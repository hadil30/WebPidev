<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "quiz")]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "quiz_id", type: "integer")]
    private ?int $quizId = null;

    #[ORM\Column(name: "decrp", type: "string", length: 255, nullable: true)]
    private ?string $decrp = null;

    #[ORM\Column(name: "titre", type: "string", length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(name: "nb_quest", type: "integer", nullable: true)]
    private ?int $nbQuest = null;

    #[ORM\Column(name: "categorie", type: "string", length: 255, nullable: true)]
    private ?string $categorie = null;

    #[ORM\Column(name: "user_id", type: "integer", nullable: true)]
    private ?int $userId = null;

    #[ORM\Column(name: "image_url", type: "string", length: 255, nullable: true)]
    private ?string $imageUrl = null;

    // Getters and setters
}
