<?php

namespace App\Entity;

use App\Repository\QuestionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionsRepository::class)
 */
class Questions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intitule;

    /**
     * @ORM\ManyToMany(targetEntity=InformationsComplementaires::class, mappedBy="question")
     */
    private $informationsComplementaires;


    /**
     * @ORM\ManyToOne(targetEntity=Questionnaire::class, inversedBy="questions")
     */
    private $questionnaire;

    /**
     * @ORM\OneToMany(targetEntity=Reponses::class, mappedBy="questions")
     */
    private $reponses;

    /**
     * @ORM\ManyToOne(targetEntity=ThematiqueQuestion::class, inversedBy="questions")
     */
    private $thematiqueQuestion;

    public function __construct()
    {
        $this->informationsComplementaires = new ArrayCollection();
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * @return Collection|InformationsComplementaires[]
     */
    public function getInformationsComplementaires(): Collection
    {
        return $this->informationsComplementaires;
    }

    public function addInformationsComplementaire(InformationsComplementaires $informationsComplementaire): self
    {
        if (!$this->informationsComplementaires->contains($informationsComplementaire)) {
            $this->informationsComplementaires[] = $informationsComplementaire;
            $informationsComplementaire->addQuestion($this);
        }

        return $this;
    }

    public function removeInformationsComplementaire(InformationsComplementaires $informationsComplementaire): self
    {
        if ($this->informationsComplementaires->removeElement($informationsComplementaire)) {
            $informationsComplementaire->removeQuestion($this);
        }

        return $this;
    }


    public function getQuestionnaire(): ?Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(?Questionnaire $questionnaire): self
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    /**
     * @return Collection|Reponses[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponses $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setQuestions($this);
        }

        return $this;
    }

    public function removeReponse(Reponses $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestions() === $this) {
                $reponse->setQuestions(null);
            }
        }

        return $this;
    }

    public function getThematiqueQuestion(): ?ThematiqueQuestion
    {
        return $this->thematiqueQuestion;
    }

    public function setThematiqueQuestion(?ThematiqueQuestion $thematiqueQuestion): self
    {
        $this->thematiqueQuestion = $thematiqueQuestion;

        return $this;
    }
}
