<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
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
    #[Assert\NotBlank(message: "The name cannot be blank")]
    #[Assert\Length(max: 255, maxMessage: "The name cannot be longer than {{ limit }} characters")]
    private ?string $nom;

    #[ORM\Column(type: "text")]
    #[Assert\NotBlank(message: "The description cannot be blank")]
    private ?string $description;

    #[ORM\Column(name: "temp_pris", type: "datetime")]
    private ?\DateTimeInterface $tempPris = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: "The status cannot be longer than {{ limit }} characters")]
    private ?string $status = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Assert\Choice(
        choices: ['Language', 'Academic', 'University', 'Skills', 'Citizenship', 'Knowledge', 'IQ'],
        message: "Please select a category"
    )]
    private ?string $categorie;




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
    #[Assert\Count(
        min: 1,
        minMessage: "The test must have at least one question"
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
