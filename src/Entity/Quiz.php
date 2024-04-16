<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: "quiz")]
#[ORM\Entity]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "quiz_id", type: "integer", nullable: false)]
    public $quizId;
 
    #[Assert\NotBlank(message:"Your quiz must have a description")]
    #[Assert\Length(min: 10, minMessage:"The description must be at least 10 characters long")]
    #[ORM\Column(name: "decrp", type: "string", length: 255, nullable: true)]
    private $decrp;

    #[Assert\NotBlank(message:"Your quiz must have a title")]
    #[Assert\Length(min: 10, minMessage:"The question must be at least 10 characters long")]
    #[ORM\Column(name: "titre", type: "string", length: 255, nullable: true)]
    private $titre;

    #[ORM\Column(name: "nb_quest", type: "integer", nullable: true)]
    private $nbQuest;

    #[Assert\NotBlank(message:"Your quiz must have a categorie")]
    #[Assert\Length(min: 10, minMessage:"The question must be at least 10 characters long")]
    #[ORM\Column(name: "categorie", type: "string", length: 255, nullable: true)]
    private $categorie;

    #[ORM\Column(name: "user_id", type: "integer", nullable: true)]
    private $userId;

    #[ORM\Column(name: "image_url", type: "string", length: 255, nullable: true)]
    public $imageUrl;

    public function getQuizId(): ?int
    {
        return $this->quizId;
    }

    public function getDecrp(): ?string
    {
        return $this->decrp;
    }

    public function setDecrp(?string $decrp): static
    {
        $this->decrp = $decrp;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNbQuest(): ?int
    {
        return $this->nbQuest;
    }

    public function setNbQuest(?int $nbQuest): static
    {
        $this->nbQuest = $nbQuest;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
    public function __toString()
    {
        return $this->quizId;
    }
}
