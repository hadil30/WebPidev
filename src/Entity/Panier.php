<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "panier", indexes: [new ORM\Index(name: "id_liv", columns: ["id_liv"])])]
class Panier
{
    #[ORM\Id]
    #[ORM\Column(name: "id_panier", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idPanier = null;

    #[ORM\Column(name: "total_price", type: "decimal", precision: 10, scale: 2)]
    private string $totalPrice;

    #[ORM\Column(name: "nom_liv", type: "string", length: 255, nullable: true)]
    private ?string $nomLiv = null;

    #[ORM\Column(name: "imagePath", type: "string", length: 255, nullable: true)]
    private ?string $imagepath = null;

    #[ORM\Column(name: "pdfPath", type: "blob", nullable: true)]
    private $pdfpath; // Type hinting for $pdfpath depends on how it's being used in your application

    #[ORM\ManyToOne(targetEntity: Books::class)]
    #[ORM\JoinColumn(name: "id_liv", referencedColumnName: "id_liv")]
    private ?Books $idLiv = null;

    // Getters and setters
}
