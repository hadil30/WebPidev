<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionReponse
 *
 * @ORM\Table(name="question_reponse", indexes={@ORM\Index(name="id_Questiont", columns={"id_Questiont"}), @ORM\Index(name="id_Reponse", columns={"id_Reponse"})})
 * @ORM\Entity
 */
class QuestionReponse
{
    /**
     * @var int
     *
     * @ORM\Column(name="question_reponse", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $questionReponse;

    /**
     * @var \Questiont
     *
     * @ORM\ManyToOne(targetEntity="Questiont")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_Questiont", referencedColumnName="id_Questiont")
     * })
     */
    private $idQuestiont;

    /**
     * @var \Reponse
     *
     * @ORM\ManyToOne(targetEntity="Reponse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_Reponse", referencedColumnName="id_Reponse")
     * })
     */
    private $idReponse;

    public function getQuestionReponse(): ?int
    {
        return $this->questionReponse;
    }

    public function getIdQuestiont(): ?Questiont
    {
        return $this->idQuestiont;
    }

    public function setIdQuestiont(?Questiont $idQuestiont): static
    {
        $this->idQuestiont = $idQuestiont;

        return $this;
    }

    public function getIdReponse(): ?Reponse
    {
        return $this->idReponse;
    }

    public function setIdReponse(?Reponse $idReponse): static
    {
        $this->idReponse = $idReponse;

        return $this;
    }


}
