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
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "user_id", type: "integer", nullable: false)]
    private int $userId;

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

    /**
     * @var string The hashed password
     */
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


    // Getters
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getDatenes(): \DateTime
    {
        return $this->datenes;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function getPswd(): string
    {
        return $this->pswd;
    }

    /**
     * @see UserInterface
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return [$this->convertRoleToString($this->role)];
    }

    private function convertRoleToString(int $roleInt): string
    {
        switch ($roleInt) {
            case 0:
                return 'etudiant';
            case 1:
                return 'professeur';
            case 2:
                return 'admin';
            default:
                return ''; // Handle other cases as needed
        }
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getActif(): ?int
    {
        return $this->actif;
    }

    // Setters
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function setDatenes(\DateTime $datenes): void
    {
        $this->datenes = $datenes;
    }

    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    public function setPswd(string $pswd): void
    {
        $this->pswd = $pswd;
    }

    public function setRoles(int $role): static
    {
        $this->role = $role;
        return $this;
    }

    public function setRole(int $role): void
    {
        $this->role = $role;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function setActif(?int $actif): void
    {
        $this->actif = $actif;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->nom;
    }


    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->nom;
    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->pswd;
    }

    public function setPassword(string $password): static
    {
        $this->pswd = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        //$this->plainPassword = null;
    }
}
