<?php

namespace App\Entity;

use App\Repository\TestUtilisateurRepository;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "test_utilisateur", indexes: [
    [new ORM\Index(name: "user_id", columns: ["user_id"])],
    [new ORM\Index(name: "id_Test", columns: ["id_Test"])]
])]
#[ORM\Entity(repositoryClass: TestUtilisateurRepository::class)]
class TestUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_test_utilisateur", type: "integer", nullable: false)]
    private int $idTestUtilisateur;

    #[ORM\Column(name: "score", type: "string", length: 255, nullable: true)]
    private ?string $score;

    #[ORM\ManyToOne(targetEntity: "User")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "user_id")]
    private User $user;

    #[ORM\ManyToOne(targetEntity: "Test")]
    #[ORM\JoinColumn(name: "id_Test", referencedColumnName: "id_Test")]
    private Test $idTest;

    // Getters and setters
}
