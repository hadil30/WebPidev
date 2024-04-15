<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "question_reponse")]
class QuestionReponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "question_reponse", type: "integer")]
    private ?int $id = null;

    // In QuestionReponse.php
    #[ORM\ManyToOne(targetEntity: Questiont::class, inversedBy: "questionReponse")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Questiont $questiont;

    // Ensure getters and setters are correctly defined for this $questiont property
    public function getQuestiont(): ?Questiont
    {
        return $this->questiont;
    }

    public function setQuestiont(?Questiont $questiont): self
    {
        $this->questiont = $questiont;
        return $this;
    }


    #[ORM\ManyToOne(targetEntity: Reponse::class, inversedBy: "questionReponse")] // Add inversedBy attribute here
    #[ORM\JoinColumn(name: "id_Reponse", referencedColumnName: "id_Reponse")]
    private ?Reponse $reponse = null;

    // Getter and setter for id
    public function getId(): ?int
    {
        return $this->id;
    }


    // Getter and setter for reponse
    public function getReponse(): ?Reponse
    {
        return $this->reponse;
    }

    public function setReponse(?Reponse $reponse): self
    {
        $this->reponse = $reponse;
        return $this;
    }
}
