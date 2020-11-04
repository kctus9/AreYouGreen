<?php

namespace App\Entity;

use App\Repository\InformationsComplementairesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InformationsComplementairesRepository::class)
 */
class InformationsComplementaires
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $leSaviezVous;

    /**
     * @ORM\ManyToMany(targetEntity=Questions::class, inversedBy="informationsComplementaires")
     */
    private $question;

    public function __construct()
    {
        $this->question = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLeSaviezVous(): ?string
    {
        return $this->leSaviezVous;
    }

    public function setLeSaviezVous(string $leSaviezVous): self
    {
        $this->leSaviezVous = $leSaviezVous;

        return $this;
    }

    /**
     * @return Collection|Questions[]
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(Questions $question): self
    {
        if (!$this->question->contains($question)) {
            $this->question[] = $question;
        }

        return $this;
    }

    public function removeQuestion(Questions $question): self
    {
        $this->question->removeElement($question);

        return $this;
    }
}
