<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "books")]
#[ORM\Entity]
class Books
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idLiv;

    #[ORM\Column(type: "string", length: 255)]
    private string $nomLiv;

    #[ORM\Column(type: "string", length: 255)]
    private string $disponibiliteLiv;

    #[ORM\Column(type: "string", length: 255)]
    private string $categorieLiv;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private string $prixLiv;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imagepath;

    #[ORM\Column(type: "blob", nullable: true)]
    private $pdfpath;

    public function getIdLiv(): ?int
    {
        return $this->idLiv;
    }

    public function getNomLiv(): string
    {
        return $this->nomLiv;
    }

    public function setNomLiv(string $nomLiv): self
    {
        $this->nomLiv = $nomLiv;
        return $this;
    }

    public function getDisponibiliteLiv(): string
    {
        return $this->disponibiliteLiv;
    }

    public function setDisponibiliteLiv(string $disponibiliteLiv): self
    {
        $this->disponibiliteLiv = $disponibiliteLiv;
        return $this;
    }

    public function getCategorieLiv(): string
    {
        return $this->categorieLiv;
    }

    public function setCategorieLiv(string $categorieLiv): self
    {
        $this->categorieLiv = $categorieLiv;
        return $this;
    }

    public function getPrixLiv(): string
    {
        return $this->prixLiv;
    }

    public function setPrixLiv(string $prixLiv): self
    {
        $this->prixLiv = $prixLiv;
        return $this;
    }

    public function getImagepath(): ?string
    {
        return $this->imagepath;
    }

    public function setImagepath(?string $imagepath): self
    {
        $this->imagepath = $imagepath;
        return $this;
    }

    public function getPdfpath()
    {
        return $this->pdfpath;
    }

    public function setPdfpath($pdfpath): self
    {
        $this->pdfpath = $pdfpath;
        return $this;
    }
}
