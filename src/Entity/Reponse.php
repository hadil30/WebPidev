<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Table(name: "reponse")]
#[ORM\Entity(repositoryClass: ReponseRepository::class)]

class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_Reponse", type: "integer")]
    private int $idReponse;

    #[ORM\Column(name: "is_correct", type: "boolean")]
    private bool $isCorrect;

    #[ORM\Column(name: "reponse", type: "string", length: 255, nullable: true)]
    private ?string $reponse = null;
    public function getIdReponse(): int
    {
        return $this->idReponse;
    }

    public function getIsCorrect(): bool
    {
        return $this->isCorrect;
    }


    public function setIsCorrect(bool $isCorrect): self
    {
        $this->isCorrect = $isCorrect;
        return $this;
    }


    public function getReponse(): ?string
    {
        return $this->reponse;
    }


    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;
        return $this;
    }


    #[ORM\ManyToMany(targetEntity: Questiont::class, cascade: ['persist'])]
    #[ORM\JoinTable(
        name: "question_reponse",
        joinColumns: [
            new ORM\JoinColumn(name: "id_Reponse", referencedColumnName: "id_Reponse")
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: "id_Questiont", referencedColumnName: "id_Questiont")
        ]
    )]

    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }


    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Questiont $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
        }

        return $this;
    }

    public function removeQuestion(Questiont $question): self
    {
        $this->questions->removeElement($question);

        return $this;
    }
    public function __toString(): string
    {
        // Customize the string representation according to your needs
        return $this->reponse;
    }
}
