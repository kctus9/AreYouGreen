<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 */
class Articles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\ManyToMany(targetEntity=Thematique::class, inversedBy="articles")
     */
    private $thematique;

    public function __construct()
    {
        $this->thematique = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * @return Collection|Thematique[]
     */
    public function getThematique(): Collection
    {
        return $this->thematique;
    }

    public function addThematique(Thematique $thematique): self
    {
        if (!$this->thematique->contains($thematique)) {
            $this->thematique[] = $thematique;
        }

        return $this;
    }

    public function removeThematique(Thematique $thematique): self
    {
        $this->thematique->removeElement($thematique);

        return $this;
    }
}
