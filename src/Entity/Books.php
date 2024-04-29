<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

// #[ORM\Entity]
#[ORM\Table(name: "books")]
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Books
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idLiv = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le nom du livre ne peut pas être vide")]
    private string $nomLiv;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "La disponibilité du livre ne peut pas être vide")]

    private string $disponibiliteLiv;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "La catégorie du livre ne peut pas être vide")]
    private string $categorieLiv;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    #[Assert\NotBlank(message: "Le prix du livre ne peut pas être vide")]
    #[Assert\Type(type: "numeric", message: "Le prix du livre doit être numérique")]
    #[Assert\Range(min: 0, minMessage: "Le prix du livre doit être supérieur ou égal à {{ limit }}")]
    private string $prixLiv;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    // #[Assert\NotBlank(message: "L'image du livre ne peut pas être vide")]
    private ?string $imagePath = null;



    #[ORM\Column(type: "string", length: 255, nullable: true)]
    // #[Assert\NotBlank(message: "Le PDF du livre ne peut pas être vide")]
    private ?string $pdfPath = null;

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

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getPdfPath(): ?string
    {
        return $this->pdfPath;
    }

    public function setPdfPath($pdfPath): self
    {
        $this->pdfPath = $pdfPath;

        return $this;
    }
}
