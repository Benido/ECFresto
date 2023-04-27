<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $maxCapacity = null;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: BusinessHours::class)]
    private Collection $businessHours;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $reservations;
/*
        public function __construct()
        {
            $this->businessHours = new ArrayCollection();
            $this->reservations = new ArrayCollection();
        }
    */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaxCapacity(): ?int
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(int $maxCapacity): self
    {
        $this->maxCapacity = $maxCapacity;

        return $this;
    }

    public function displayName(): string
    {
        return "le Quai Antique";
    }

    /**
     * @return Collection<int, BusinessHours>
     */
    /*
        public function getBusinessHours(): Collection
        {
            return $this->businessHours;
        }

        public function addBusinessHours(BusinessHours $businessHours): self
        {
            if (!$this->businessHours->contains($businessHours)) {
                $this->businessHours->add($businessHours);
                $businessHours->setRestaurant($this);
            }
            return $this;
        }

        public function removeBusinessHours(BusinessHours $businessHours): self
        {
            if ($this->businessHours->removeElement($businessHours)) {
                // set the owning side to null (unless already changed)
                if ($businessHours->getRestaurant() === $this) {
                    $businessHours->setRestaurant(null);
                }
            }

            return $this;
        }

        /**
         * @return Collection<int, Reservation>
         */
    /*
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setRestaurant($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRestaurant() === $this) {
                $reservation->setRestaurant(null);
            }
        }

        return $this;
    }
*/
}
