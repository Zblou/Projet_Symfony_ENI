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
    private Collection $students;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Sortie::class, orphanRemoval: true)]
    private Collection $campusTrips;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->campusTrips= new ArrayCollection();
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
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Participant $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setCampus($this);
        }

        return $this;
    }

    public function removeStudent(Participant $student): static
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getCampus() === $this) {
                $student->setCampus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSortiesCampus(): Collection
    {
        return $this->campusTrips;
    }

    public function addSortiesCampus(Sortie $campusTrips): static
    {
        if (!$this->campusTrips->contains($campusTrips)) {
            $this->campusTrips->add($campusTrips);
            $campusTrips->setCampus($this);
        }

        return $this;
    }

    public function removeSortiesCampus(Sortie $campusTrips): static
    {
        if ($this->campusTrips->removeElement($campusTrips)) {
            // set the owning side to null (unless already changed)
            if ($campusTrips->getCampus() === $this) {
                $campusTrips->setCampus(null);
            }
        }

        return $this;
    }
}
