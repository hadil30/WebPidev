<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "test_utilisateur")]
class TestUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: "integer")]
    private ?int $id_test_utilisateur = null;

    #[ORM\Column(name: "user_id", type: "integer", nullable: true)]
    private ?int $user_id = null;

    #[ORM\Column(name: "id_Test", type: "integer", nullable: true)]
    private ?int $id_Test = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $score = null;

    public function getIdTestUtilisateur(): ?int
    {
        return $this->id_test_utilisateur;
    }

    public function setIdTestUtilisateur(?int $id_test_utilisateur): self
    {
        $this->id_test_utilisateur = $id_test_utilisateur;
        return $this;
    }

    // Getter and setter for userId
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

    // Getter and setter for testId
    public function getTestId(): ?int
    {
        return $this->id_Test;
    }

    public function setTestId(?int $testId): self
    {
        $this->id_Test = $testId;
        return $this;
    }

    // Getter and setter for score
    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(?string $score): self
    {
        $this->score = $score;
        return $this;
    }
}
