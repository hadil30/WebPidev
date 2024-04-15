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
    public function getIdPanier(): ?int
    {
        return $this->idPanier;
    }

    public function getTotalPrice(): string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(string $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    public function getNomLiv(): ?string
    {
        return $this->nomLiv;
    }

    public function setNomLiv(?string $nomLiv): void
    {
        $this->nomLiv = $nomLiv;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function getPdfPath()
    {
        return $this->pdfPath;
    }

    public function setPdfPath($pdfPath): void
    {
        $this->pdfPath = $pdfPath;
    }

    public function getIdLiv(): ?Liv
    {
        return $this->idLiv;
    }

    public function setIdLiv(?Liv $idLiv): void
    {
        $this->idLiv = $idLiv;
    }
}