<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "cours")]
class Cours
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $titre;

    #[ORM\Column(type: "string", length: 255)]
    private string $description;

    #[ORM\Column(type: "string", length: 255)]
    private string $niveau;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imagepath = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $link = null;

    // Getters and setters
}
