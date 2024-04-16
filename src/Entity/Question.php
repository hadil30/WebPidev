<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "question", indexes: [new ORM\Index(name: "fk_quiz_id", columns: ["quiz_id"])])]
class Question
{
    #[ORM\Id]
    #[ORM\Column(name: "id_quest", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    public ?int $idQuest = null;

    #[Assert\NotBlank(message:"Your quiz must have a question")]
    #[Assert\Length(min: 10, minMessage:"The question must be at least 10 characters long")]
    #[ORM\Column(name: "quest", type: "string", length: 255, nullable: true)]
    public ?string $quest = null;

    #[Assert\NotBlank(message:"Choice 1 is required")]
    #[Assert\NotEqualTo(propertyPath: "rep4", message: "Each choice must be different.")]
    #[Assert\NotEqualTo(propertyPath: "rep2", message: "Each choice must be different.")]
    #[Assert\NotEqualTo(propertyPath: "rep3", message: "Each choice must be different.")]
    #[ORM\Column(name: "rep1", type: "string", length: 255)]
    public string $rep1;
    #[Assert\NotBlank(message:"Choice 2 is required")]
    #[Assert\NotEqualTo(propertyPath: "rep4", message: "Each choice must be different.")]
    #[Assert\NotEqualTo(propertyPath: "rep1", message: "Each choice must be different.")]
    #[Assert\NotEqualTo(propertyPath: "rep3", message: "Each choice must be different.")]
    #[ORM\Column(name: "rep2", type: "string", length: 255)]
    public string $rep2;
    #[Assert\NotBlank(message:"Choice 3 is required")]
    #[Assert\NotEqualTo(propertyPath: "rep4", message: "Each choice must be different.")]
    #[Assert\NotEqualTo(propertyPath: "rep2", message: "Each choice must be different.")]
    #[Assert\NotEqualTo(propertyPath: "rep1", message: "Each choice must be different.")]
    #[ORM\Column(name: "rep3", type: "string", length: 255)]
    public string $rep3;
    #[Assert\NotBlank(message:"Choice 4 is required")]
    #[Assert\NotEqualTo(propertyPath: "rep3", message: "Each choice must be different.")]
    #[Assert\NotEqualTo(propertyPath: "rep2", message: "Each choice must be different.")]
    #[Assert\NotEqualTo(propertyPath: "rep1", message: "Each choice must be different.")]
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