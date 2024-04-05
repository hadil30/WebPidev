<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "test")]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_Test", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "nom_Test", type: "string", length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: "text")]
    private ?string $description = null;

    #[ORM\Column(name: "temp_pris", type: "datetime")]
    private ?\DateTimeInterface $tempPris = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $categorie = null;



    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nomTest): self
    {
        $this->nom = $nomTest;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getTempPris(): ?\DateTimeInterface
    {
        return $this->tempPris;
    }

    public function setTempPris(?\DateTimeInterface $tempPris): self
    {
        $this->tempPris = $tempPris;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;
        return $this;
    }

    #[ORM\ManyToMany(targetEntity: Questiont::class, cascade: ['persist'])]
    #[ORM\JoinTable(
        name: "test_question",
        joinColumns: [
            new ORM\JoinColumn(name: "id_Test", referencedColumnName: "id_Test")
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
}
