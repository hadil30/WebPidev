<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "discussion", indexes: [new ORM\Index(name: "user_id", columns: ["user_id"]), new ORM\Index(name: "id_Cours", columns: ["id_Cours"])])]
class Discussion
{
    #[ORM\Id]
    #[ORM\Column(name: "id_Discussion", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idDiscussion = null;

    #[ORM\Column(name: "Titre_DISCUSSION", type: "string", length: 255, nullable: true)]
    private ?string $titreDiscussion = null;

    #[ORM\Column(name: "Message", type: "text", nullable: true)]
    private ?string $message = null;

    #[ORM\Column(name: "date_Post", type: "datetime", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTime $datePost;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "user_id")]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Cours::class)]
    #[ORM\JoinColumn(name: "id_Cours", referencedColumnName: "id")]
    private ?Cours $idCours = null;

    // Getters and setters
}
