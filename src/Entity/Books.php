<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "books")]
class Books
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idLiv = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $nomLiv;

    #[ORM\Column(type: "string", length: 255)]
    private string $disponibiliteLiv;

    #[ORM\Column(type: "string", length: 255)]
    private string $categorieLiv;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private string $prixLiv;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imagepath = null;

    #[ORM\Column(type: "blob", nullable: true)]
    private $pdfpath;

    // Getters and Setters
}
