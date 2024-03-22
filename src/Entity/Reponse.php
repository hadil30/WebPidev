<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReponseRepository;

#[ORM\Entity]
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
    private ?string $reponse = null;
    // Getters and setters

}
