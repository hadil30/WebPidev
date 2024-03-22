<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "test")]
#[ORM\Entity(repositoryClass: TestRepository::class)]

class Test
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idTest = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $nomTest = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $tempPris = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $categorie = null;

    // Getters and setters
}
