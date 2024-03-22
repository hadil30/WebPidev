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
    private int $userId;

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

    // Getters and setters
}
