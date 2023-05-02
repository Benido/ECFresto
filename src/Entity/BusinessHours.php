<?php

namespace App\Entity;

use App\Enum\Weekdays;
use App\Repository\BusinessHoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BusinessHoursRepository::class)]
class BusinessHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(enumType: Weekdays::class)]
    private Weekdays $weekday ;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $openingHour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $closingHour = null;

    #[ORM\ManyToOne(inversedBy: 'businessHours')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Restaurant $restaurant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeekday(): Weekdays
    {
        return $this->weekday;
    }

    public function getWeekdayString(): string
    {
        return $this->getWeekday()->label();
    }

    public function setWeekday(Weekdays $weekday): self
    {
        $this->weekday = $weekday;

        return $this;
    }

    public function getOpeningHour(): ?\DateTimeInterface
    {
        return $this->openingHour;
    }

    public function setOpeningHour(?\DateTimeInterface $openingHour): self
    {
        $this->openingHour = $openingHour;

        return $this;
    }

    public function getClosingHour(): ?\DateTimeInterface
    {
        return $this->closingHour;
    }

    public function setClosingHour(?\DateTimeInterface $closingHour): self
    {
        $this->closingHour = $closingHour;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    //Return a formatted table of string values
    public function getFormattedBusinessHours(): array
    {
        return [
            $this->getWeekdayString(), [
                $this->getOpeningHour()?->format('H:i'),
                $this->getClosingHour()?->format('H:i')
            ]
        ];
    }

    //We substract one hour to the closing hour to get the last time slot
    public function getLastTimeSlot(): ?\DateTimeInterface
    {
        return $this->getClosingHour()?->sub(new \DateInterval('PT1H'));
    }
}
