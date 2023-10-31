<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'This field can\'t be empty')]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: 'This field can\'t be empty')]
    private ?string $postalCode = null;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: place::class, orphanRemoval: true)]
    private Collection $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
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

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection<int, place>
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlaces(Place $places): static
    {
        if (!$this->places->contains($places)) {
            $this->places->add($places);
            $places->setVille($this);
        }

        return $this;
    }

    public function removePlaces(Place $places): static
    {
        if ($this->places->removeElement($places)) {
            // set the owning side to null (unless already changed)
            if ($places->getVille() === $this) {
                $places->setVille(null);
            }
        }

        return $this;
    }
}
