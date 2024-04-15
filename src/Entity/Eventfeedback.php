<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Contracts\EventDispatcher\Event;

#[ORM\Entity]
#[ORM\Table(name: "event_feedback")]
class Eventfeedback
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_event_feedback", type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Events::class, inversedBy: "Eventfeedback")]
    #[ORM\JoinColumn(name: "EVENT_ID", referencedColumnName: "EVENT_ID")]
    private ?Events $event = null;

    #[ORM\ManyToOne(targetEntity: Feedback::class)]
    #[ORM\JoinColumn(name: "ID_feedback", referencedColumnName: "ID_feedback")]
    private ?Feedback $feedback = null;

    // Getters and setters for $event
    public function getEvent(): ?Events
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;
        return $this;
    }

    // Getters and setters for $feedback
    public function getFeedback(): ?Feedback
    {
        return $this->feedback;
    }

    public function setFeedback(?Feedback $feedback): self
    {
        $this->feedback = $feedback;
        return $this;
    }
}
