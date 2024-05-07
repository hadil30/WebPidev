<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "user")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "user_id", type: "integer", nullable: false)]
    public int $userId;

    #[ORM\Column(name: "nom", type: "string", length: 50, nullable: false)]
    private string $nom;

    #[ORM\Column(name: "prenom", type: "string", length: 50, nullable: false)]
    private string $prenom;

    #[ORM\Column(name: "datenes", type: "date", nullable: false)]
    private \DateTime $datenes;

    #[ORM\Column(name: "mail", type: "string", length: 50, nullable: false)]
    private string $mail;

    #[ORM\Column(name: "pswd", type: "string", length: 255, nullable: false)]
    private string $pswd;

    #[ORM\Column(name: "role", type: "integer", nullable: false)]
    private int $role;

    #[ORM\Column(name: "image", type: "string", length: 50, nullable: false)]
    private string $image;

    #[ORM\Column(name: "actif", type: "integer", nullable: true)]
    private ?int $actif;


    public function getId(): ?int
    {
        return $this->userId;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getDatenes(): ?\DateTime
    {
        return $this->datenes;
    }

    public function setDatenes(\DateTime $datenes): self
    {
        $this->datenes = $datenes;
        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;
        return $this;
    }

    public function getPswd(): ?string
    {
        return $this->pswd;
    }

    public function setPswd(string $pswd): self
    {
        $this->pswd = $pswd;
        return $this;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getActif(): ?int
    {
        return $this->actif;
    }

    public function setActif(?int $actif): self
    {
        $this->actif = $actif;
        return $this;
    }
}
