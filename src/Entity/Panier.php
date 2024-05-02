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
    public ?int $idPanier = null;

    #[ORM\Column(name: "total_price", type: "decimal", precision: 10, scale: 2)]
    public string $totalPrice;

    #[ORM\Column(name: "nom_liv", type: "string", length: 255, nullable: true)]
    public ?string $nomLiv = null;

    #[ORM\Column(name: "imagePath", type: "string", length: 255, nullable: true)]
    public ?string $imagepath = null;

    #[ORM\Column(name: "pdfPath", type: "string", length: 255, nullable: true)]
    public ?string $pdfpath; // Type hinting for $pdfpath depends on how it's being used in your application

    #[ORM\ManyToOne(targetEntity: Books::class)]
    #[ORM\JoinColumn(name: "id_liv", referencedColumnName: "id_liv")]
    public ?Books $idLiv = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "user_id")]
    public ?User $iduser = null;

    // Getters and setters

    public function getIdPanier(): ?int
    {
        return $this->idPanier;
    }
    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): void
    {
        $this->iduser = $iduser;
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

    public function getImagepath(): ?string
    {
        return $this->imagepath;
    }

    public function setImagepath(?string $imagepath): void
    {
        $this->imagepath = $imagepath;
    }

    public function getPdfpath(): ?string
    {
        return $this->pdfpath;
    }

    public function setPdfpath($pdfpath): void
    {
        $this->pdfpath = $pdfpath;
    }

    public function getIdLiv(): ?Books
    {
        return $this->idLiv;
    }

    public function setIdLiv(?Books $idLiv): void
    {
        $this->idLiv = $idLiv;
    }
}
