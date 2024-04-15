<?php

namespace App\Entity;

use App\Repository\QuestiontRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Table(name: "questiont")]
#[ORM\Entity(repositoryClass: QuestiontRepository::class)]
class Questiont
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_Questiont", type: "integer")]
    private ?int $idQuestiont = null;

    #[ORM\Column(name: "text", type: "text", nullable: true)]
    #[Assert\Length(max: 1000, maxMessage: "The text cannot be longer than {{ limit }} characters")]
    private ?string $text = null;

    public function getIdQuestiont(): ?int
    {
        return $this->idQuestiont;
    }

    public function setIdQuestiont(?int $idQuestiont): self
    {
        $this->idQuestiont = $idQuestiont;
        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;
        return $this;
    }

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
        $this->reponses = new ArrayCollection();
    }

    public function getReponses(): Collection
    {

        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        // dump('hello add response');
        //die();

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
}
