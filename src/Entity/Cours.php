<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CoursRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: "cours")]
#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le titre ne peut pas être vide")]
    private string $titre;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "La description ne peut pas être vide")]
    private string $description;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le niveau ne peut pas être vide")]
    private string $niveau;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(
     *     maxSize="5M",
     *     mimeTypes={"image/jpeg", "image/png", "image/gif"},
     *     mimeTypesMessage="Veuillez télécharger une image valide (jpeg, png, gif)",
     *     uploadErrorMessage="Une erreur s'est produite lors du téléchargement de l'image"
     * )
     */
    #[ORM\Column(name: "ImagePath", type: "string", length: 255)]
    private ?string $ImagePath = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\Url(message: "Le lien de la vidéo doit être une URL valide")]
    private ?string $link = null;

    // Getters and setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->ImagePath;
    }

    public function setImagePath(?string $ImagePath): self
    {
        $this->ImagePath = $ImagePath;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
