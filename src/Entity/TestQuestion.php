<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "test_question")]
class TestQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_test_question", type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Test::class, inversedBy: "testQuestions")]
    #[ORM\JoinColumn(name: "id_Test", referencedColumnName: "id_Test")]
    private ?Test $test = null;

    #[ORM\ManyToOne(targetEntity: Questiont::class)]
    #[ORM\JoinColumn(name: "id_Questiont", referencedColumnName: "id_Questiont")]
    private ?Questiont $questiont = null;

    // Getters and setters for $test
    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): self
    {
        $this->test = $test;
        return $this;
    }

    // Getters and setters for $question
    public function getQuestiont(): ?Questiont
    {
        return $this->questiont;
    }

    public function setQuestiont(?Questiont $question): self
    {
        $this->questiont = $question;
        return $this;
    }
}
