<?php

namespace App\Entity;

use Symfony\Component\Uid\Uuid;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use App\Repository\ClientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $defaultSeatsNumber = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $allergens = [];

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getDefaultSeatsNumber(): ?int
    {
        return $this->defaultSeatsNumber;
    }

    public function setDefaultSeatsNumber(?int $defaultSeatsNumber): self
    {
        $this->defaultSeatsNumber = $defaultSeatsNumber;

        return $this;
    }

    public function getAllergens(): array
    {
        return $this->allergens;
    }

    public function setAllergens(array $allergens): self
    {
        $this->allergens = $allergens;

        return $this;
    }
}
