<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Void_;

#[ORM\Entity]
#[ORM\Table(name: "feedback")]
class Feedback
{
    #[ORM\Id]
    #[ORM\Column(name: "ID_feedback", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $id = null;

    #[ORM\Column(name: "EVENT_ID", type: "integer")]
    private int $eventId;

    #[ORM\Column(name: "REPONSE", type: "string", length: 1000)]
    private string $reponse;

    #[ORM\Column(name: "DATE", type: "date")]
    private \DateTime $date;
    
    #[ORM\Column(name: "user_id", type: "INTEGER")]
    private int $user;

    

    // Getters and setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

    public function setEventId(int $eventId): void
    {
        $this->eventId = $eventId;
    }

    public function getReponse(): string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): void
    {
        $this->reponse = $reponse;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getUser(): int
    {
        return $this->user;
    }

    public function setUser(?int $user): void
    {
        $this->user = $user;
    }
}
