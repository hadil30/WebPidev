<?php

namespace App\Entity;

use App\Repository\QuestiontRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "questiont")]
#[ORM\Entity(repositoryClass: QuestiontRepository::class)]
class Questiont
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_Questiont", type: "integer")]
    private ?int $idQuestiont = null;

    #[ORM\Column(name: "text", type: "text", nullable: true)]
    private ?string $text = null;




    // Getter and setter for idQuestiont
    public function getIdQuestiont(): ?int
    {
        return $this->idQuestiont;
    }

    public function setIdQuestiont(?int $idQuestiont): self
    {
        $this->idQuestiont = $idQuestiont;
        return $this;
    }

    // Getter and setter for text
    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;
        return $this;
    }

    #[ORM\ManyToMany(targetEntity: Test::class, cascade: ['persist'])]
    #[ORM\JoinTable(
        name: "test_question",
        joinColumns: [
            new ORM\JoinColumn(name: "id_Questiont", referencedColumnName: "id_Questiont")
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: "id_Test", referencedColumnName: "id_Test")
        ]
    )]
    private Collection $tests;

    #[ORM\ManyToMany(targetEntity: Reponse::class, cascade: ['persist'])]
    #[ORM\JoinTable(
        name: "question_reponse",
        joinColumns: [
            new ORM\JoinColumn(name: "id_Questiont", referencedColumnName: "id_Questiont")
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: "id_Reponse", referencedColumnName: "id_Reponse")
        ]
    )]
    private Collection $reponses;
    public function __construct()
    {
        $this->tests = new ArrayCollection();
        $this->reponses = new ArrayCollection();
    }


    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(Test $test): self
    {
        if (!$this->tests->contains($test)) {
            $this->tests[] = $test;
        }

        return $this;
    }

    public function removeTest(Test $test): self
    {
        $this->tests->removeElement($test);

        return $this;
    }



    public function getReponses(): Collection
    {
        return $this->reponses;
    }
    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
        }

        return $this;
    }
    public function removeReponse(Reponse $reponse): self
    {
        $this->reponses->removeElement($reponse);

        return $this;
    }
    public function __toString(): string
    {
        // Customize the string representation according to your needs
        return $this->text;
    }
}
