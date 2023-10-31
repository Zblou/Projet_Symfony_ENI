<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Veuillez renseigner un nom pour votre campus')]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Participant::class, orphanRemoval: true)]
    private Collection $etudiants;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Trip::class, orphanRemoval: true)]
    private Collection $sortiesCampus;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->sortiesCampus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Participant $etudiant): static
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants->add($etudiant);
            $etudiant->setCampus($this);
        }

        return $this;
    }

    public function removeEtudiant(Participant $etudiant): static
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getCampus() === $this) {
                $etudiant->setCampus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Trip>
     */
    public function getSortiesCampus(): Collection
    {
        return $this->sortiesCampus;
    }

    public function addSortiesCampus(Trip $sortiesCampus): static
    {
        if (!$this->sortiesCampus->contains($sortiesCampus)) {
            $this->sortiesCampus->add($sortiesCampus);
            $sortiesCampus->setCampus($this);
        }

        return $this;
    }

    public function removeSortiesCampus(Trip $sortiesCampus): static
    {
        if ($this->sortiesCampus->removeElement($sortiesCampus)) {
            // set the owning side to null (unless already changed)
            if ($sortiesCampus->getCampus() === $this) {
                $sortiesCampus->setCampus(null);
            }
        }

        return $this;
    }
}
