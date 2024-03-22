<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "events", indexes: [new ORM\Index(name: "user_id", columns: ["user_id"])])]
class Events
{
    #[ORM\Id]
    #[ORM\Column(name: "EVENT_ID", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $eventId = null;

    #[ORM\Column(name: "NOM", type: "string", length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(name: "DESCRIPTION", type: "string", length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: "Typee", type: "string", length: 0, nullable: true)]
    private ?string $typee = null;

    #[ORM\Column(name: "DATEe", type: "date", nullable: true)]
    private ?\DateTimeInterface $datee = null;

    #[ORM\Column(name: "STATUS", type: "string", length: 0, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(name: "image_url", type: "string", length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "user_id")]
    private ?User $user = null;

    // Getters and setters
}
