<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;


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
    #[Assert\NotBlank(message: "The response cannot be blank.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The response cannot be longer than {{ limit }} characters."
    )]
    private ?string $reponse;
    public function getIdReponse(): int
    {
        return $this->idReponse;
    }

    public function getisCorrect(): bool
    {
        return $this->isCorrect;
    }


    public function setisCorrect(bool $isCorrect): self
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


    public function __toString(): string
    {
        // Customize the string representation according to your needs
        return $this->reponse;
    }
}
