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
    #[Assert\NotBlank(message: 'Veuillez renseigner un name pour votre campus')]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: User::class, orphanRemoval: true)]
    private Collection $students;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Trip::class, cascade: ['persist'], orphanRemoval: true)]
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(User $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setCampus($this);
        }

        return $this;
    }

    public function removeStudent(User $student): static
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
     * @return Collection<int, Trip>
     */
    public function getTripsCampus(): Collection
    {
        return $this->campusTrips;
    }

    public function addTripsCampus(Trip $campusTrips): static
    {
        if (!$this->campusTrips->contains($campusTrips)) {
            $this->campusTrips->add($campusTrips);
            $campusTrips->setCampus($this);
        }

        return $this;
    }

    public function removeTripsCampus(Trip $campusTrips): static
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
