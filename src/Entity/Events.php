<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "events")]
class Events
{
    #[ORM\Id]
    #[ORM\Column(name: "EVENT_ID", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $EVENT_ID = null;

    #[ORM\Column(name: "NOM", type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank(message: "The name cannot be blank")]
    #[Assert\Length(max: 255, maxMessage: "The name cannot be longer than {{ limit }} characters")]
    private ?string $nom = null;

    #[ORM\Column(name: "DESCRIPTION", type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank(message: "The description cannot be blank")]
    private ?string $description = null;

    #[ORM\Column(name: "Typee", type: "string", length: 0, nullable: true)]
    #[Assert\NotBlank(message: "The type cannot be blank")]
    #[Assert\Length(max: 255, maxMessage: "The status cannot be longer than {{ limit }} characters")]
    private ?string $typee = null;

    #[ORM\Column(name: "DATEe", type: "date", nullable: true)]
    #[Assert\NotBlank(message: "The date and time cannot be blank")]
    private ?\DateTimeInterface $datee = null;

    #[ORM\Column(name: "STATUS", type: "string", length: 0, nullable: true)]
    #[Assert\NotBlank(message: "The STATUS cannot be blank")]
    #[Assert\Length(max: 255, maxMessage: "The status cannot be longer than {{ limit }} characters")]
    private ?string $status = null;

    #[ORM\Column(name: "image_url", type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank(message: "The image_url cannot be blank")]
    private ?string $imageUrl = null;

    #[ORM\Column(name: "user_id", type: "integer", length: 0, nullable: true)]
    #[Assert\NotBlank(message: "The user ID cannot be blank")]
    private ?int $user_id = null;

    // Getters and setters
    public function getEventId(): ?int
    {
        return $this->EVENT_ID;
    }

    public function setEventId(?int $EVENT_ID): void
    {
        $this->EVENT_ID = $EVENT_ID;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getTypee(): ?string
    {
        return $this->typee;
    }

    public function setTypee(?string $typee): void
    {
        $this->typee = $typee;
    }

    public function getDatee(): ?\DateTimeInterface
    {
        return $this->datee;
    }

    public function setDatee(?\DateTimeInterface $datee): void
    {
        $this->datee = $datee;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }
    
    public function setUserId(?int $userId): void
    {
        $this->user_id = $userId;
    }
    #[ORM\ManyToMany(targetEntity: Feedback::class, cascade: ['persist'])]
    #[ORM\JoinTable(
        name: "event_feedback",
        joinColumns: [
            new ORM\JoinColumn(name: "EVENT_ID", referencedColumnName: "EVENT_ID")
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: "ID_feedback", referencedColumnName: "ID_feedback")
        ]
    )]
    
    private Collection $feedback;

    public function __construct()
    {
        $this->feedback = new ArrayCollection();
    }


    public function getfeedback(): Collection
    {
        return $this->feedback;
    }

    public function addfeedback(Feedback $feedback): self
    {


        if (!$this->feedback->contains($feedback)) {
            $this->feedback[] = $feedback;
        }

        return $this;
    }

    public function removefeedback(Feedback $feedback): self
    {
        $this->feedback->removeElement($feedback);

        return $this;
    }
}
