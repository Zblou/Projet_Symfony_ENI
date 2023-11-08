<?php

namespace App\Entity;

use App\DataFixtures\StateFixtures;
use App\Repository\StateRepository;
use App\Repository\TripRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le champ ne peut être vide')]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le champ ne peut être vide')]
    private ?\DateTimeImmutable $dateStartTime = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(30, message: 'La durée de la trip doit être de minimum 30 minutes.')]
    #[Assert\NotBlank(message: 'Le champ ne peut être vide')]
    private ?int $duration = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le champ ne peut être vide')]
    private ?\DateTimeImmutable $registrationDeadLine = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le champ ne peut être vide')]
    #[Assert\GreaterThan(2, message: 'Il faut au moins créer une activité dans lesquelles 2 personnes peuvent participer')]
    private ?int $nbRegistrationsMax = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $infosTrip = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $reasonCancellation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?State $state = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'trips')]
    private Collection $users;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $organizer = null;

    #[ORM\ManyToOne(inversedBy: 'tripsCampus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $campus = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Place $place = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->state = new State();
        $this->state->setName('Créée');
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

    public function getDateStartTime(): ?\DateTimeImmutable
    {
        return $this->dateStartTime;
    }

    public function setDateStartTime(\DateTimeImmutable $dateStartTime): static
    {
        $this->dateStartTime = $dateStartTime;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getRegistrationDeadLine(): ?\DateTimeImmutable
    {
        return $this->registrationDeadLine;
    }

    public function setRegistrationDeadLine(\DateTimeImmutable $RegistrationDeadLine): static
    {
        $this->registrationDeadLine = $RegistrationDeadLine;

        return $this;
    }

    public function getNbRegistrationsMax(): ?int
    {
        return $this->nbRegistrationsMax;
    }

    public function setNbRegistrationsMax(int $NbRegistrationsMax): static
    {
        $this->nbRegistrationsMax = $NbRegistrationsMax;

        return $this;
    }

    public function getInfosTrip(): ?string
    {
        return $this->infosTrip;
    }

    public function setInfosTrip(?string $infosTrip): static
    {
        $this->infosTrip = $infosTrip;

        return $this;
    }

    public function getReasonCancellation(): ?string
    {
        return $this->reasonCancellation;
    }

    public function setReasonCancellation(?string $reasonCancellation): static
    {
        $this->reasonCancellation = $reasonCancellation;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): static
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function getOrganizer(): ?User
    {
        return $this->organizer;
    }

    public function setOrganizer(?User $organizer): static
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): static
    {
        $this->campus = $campus;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): static
    {
        $this->place = $place;

        return $this;
    }
}
