<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: "user")]
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields="email", message="Cet e-mail est déjà utilisé.")
 */
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "user_id", type: "integer", nullable: false)]
    private int $user_id;

    #[ORM\Column(name: "nom", type: "string", length: 50, nullable: false)]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ.")]

    private string $nom;

    #[ORM\Column(name: "prenom", type: "string", length: 50, nullable: false)]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ.")]

    private string $prenom;

    #[ORM\Column(name: "datenes", type: "date", nullable: false)]
    #[Assert\LessThanOrEqual("today", message: "La date du naissance ne peut pas être supérieure à {{ compared_value }}.")]
    private \DateTime $datenes;

    #[ORM\Column(name: "mail", type: "string", length: 50, nullable: false, unique: true)]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ.")]
    #[Assert\Email(
        message: "L'adresse e-mail '{{ value }}' n'est pas valide."
    )]

    private string $mail;

    #[ORM\Column(name: "pswd", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ.")]
    #[Assert\Length(
        min: 8,
        minMessage: "Le mot de passe doit contenir au moins 8 caractères.",
    )]

    private string $pswd;

    #[ORM\Column(name: "role", type: "integer", nullable: false)]

    private int $role;

    #[ORM\Column(name: "image", type: "string", length: 50, nullable: false)]
    private string $image;

    #[ORM\Column(name: "actif", type: "integer", nullable: true)]
    private ?int $actif = 0;


    public function getUserId(): int
    {
        return $this->user_id;
    }
}
