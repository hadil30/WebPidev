<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "feedback", indexes: [new ORM\Index(name: "user_id", columns: ["user_id"])])]
class Feedback
{
    #[ORM\Id]
    #[ORM\Column(name: "ID", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $id = null;

    #[ORM\Column(name: "EVENT_ID", type: "integer")]
    private int $eventId;

    #[ORM\Column(name: "REPONSE", type: "string", length: 1000)]
    private string $reponse;

    #[ORM\Column(name: "DATE", type: "date")]
    private \DateTime $date;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "user_id")]
    private ?User $user = null;

    // Getters and setters
}
