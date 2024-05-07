<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DiscussionRepository;
use App\Entity\User;
use App\Entity\Cours;
#[ORM\Table(name: "discussion", indexes: [new ORM\Index(name: "user_id", columns: ["user_id"]), new ORM\Index(name: "id_Cours", columns: ["id_Cours"])])]
#[ORM\Entity(repositoryClass: DiscussionRepository::class)]
class Discussion
{
    #[ORM\Id]
    #[ORM\Column(name: "id_Discussion", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idDiscussion = null;

    #[ORM\Column(name: "Titre_DISCUSSION", type: "string", length: 255, nullable: true)]
    private ?string $titreDiscussion = null;

    #[ORM\Column(name: "Message", type: "text", nullable: true)]
    private ?string $message = null;

    #[ORM\Column(name: "date_Post", type: "datetime", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTime $datePost;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "user_id")]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Cours::class)]
    #[ORM\JoinColumn(name: "id_Cours", referencedColumnName: "id")]
    private ?Cours $idCours = null;

    // Getters and setters
    public function getIdDiscussion(): ?int
    {
        return $this->idDiscussion;
    }

    public function setIdDiscussion(?int $idDiscussion): self
    {
        $this->idDiscussion = $idDiscussion;
        return $this;
    }

    // Getter and setter for titreDiscussion
    public function getTitreDiscussion(): ?string
    {
        return $this->titreDiscussion;
    }

    public function setTitreDiscussion(?string $titreDiscussion): self
    {
        $this->titreDiscussion = $titreDiscussion;
        return $this;
    }

    // Getter and setter for message
    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    // Getter and setter for datePost
    public function getDatePost(): \DateTime
    {
        return $this->datePost;
    }

    public function setDatePost(\DateTime $datePost): self
    {
        $this->datePost = $datePost;
        return $this;
    }

    // Getter and setter for user
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    // Getter and setter for idCours
    public function getIdCours(): ?Cours
    {
        return $this->idCours;
    }

    public function setIdCours(?Cours $idCours): self
    {
        $this->idCours = $idCours;
        return $this;
    }
}
