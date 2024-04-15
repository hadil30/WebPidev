<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "question", indexes: [new ORM\Index(name: "fk_quiz_id", columns: ["quiz_id"])])]
class Question
{
    #[ORM\Id]
    #[ORM\Column(name: "id_quest", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    public ?int $idQuest = null;

    #[ORM\Column(name: "quest", type: "string", length: 255, nullable: true)]
    public ?string $quest = null;

    #[ORM\Column(name: "rep1", type: "string", length: 255)]
    public string $rep1;

    #[ORM\Column(name: "rep2", type: "string", length: 255)]
    public string $rep2;

    #[ORM\Column(name: "rep3", type: "string", length: 255)]
    public string $rep3;

    #[ORM\Column(name: "rep4", type: "string", length: 255)]
    public string $rep4;

    #[ORM\Column(name: "repc", type: "string", length: 255)]
    public string $repc;

    #[ORM\ManyToOne(targetEntity: Quiz::class)]
    #[ORM\JoinColumn(name: "quiz_id", referencedColumnName: "quiz_id")]
    public ?Quiz $quiz = null;

    public function setQuest(string $quest): void
{
    $this->quest = $quest;
}
public function getIdQuest(): ?int
{
    return $this->idQuest;
}

public function setRep1(string $rep1): void
{
    $this->rep1 = $rep1;
}

public function setRep2(string $rep2): void
{
    $this->rep2 = $rep2;
}

public function setRep3(string $rep3): void
{
    $this->rep3 = $rep3;
}

public function setRep4(string $rep4): void
{
    $this->rep4 = $rep4;
}

public function setRepc(string $repc): void
{
    $this->repc = $repc;
}

public function setQuiz(?Quiz $quiz): static
{
    $this->quiz = $quiz;
    return $this;
}
public function getQuiz(): ?Quiz
{
    return $this->quiz;
}
public function getQuest(): ?string
{
    return $this->quest;
}

public function getRep1(): ?string
{
    return $this->rep1;
}

public function getRep2(): ?string
{
    return $this->rep2;
}

public function getRep3(): ?string
{
    return $this->rep3;
}

public function getRep4(): ?string
{
    return $this->rep4;
}

public function getRepc(): ?string
{
    return $this->repc;
}

}