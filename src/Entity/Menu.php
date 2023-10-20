<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\OneToMany(
        mappedBy: 'menu',
        targetEntity: Formula::class,
        cascade: ['persist', 'remove'])]
    private Collection $formulas;

    #[ORM\ManyToMany(targetEntity: Dish::class, inversedBy: 'menus')]
    private Collection $dishes;

    public function __construct()
    {
        $this->formulas = new ArrayCollection();
        $this->dishes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Formula>
     */
    public function getFormula(): Collection
    {
        return $this->formulas;
    }

    public function addFormula(Formula $formula): self
    {
        if (!$this->formulas->contains($formula)) {
            $this->formulas->add($formula);
        }

        return $this;
    }

    public function removeFormula(Formula $relation): self
    {
        $this->formulas->removeElement($relation);

        return $this;
    }

    public function getDishes(): Collection
    {
        return $this->dishes;
    }

    public function addDish(Dish $dish): self
    {
        if (!$this->dishes->contains($dish)) {
            $this->dishes->add($dish);
        }

        return $this;
    }

    public function removeDish(Dish $dish): self
    {
        $this->dishes->removeElement($dish);

        return $this;
    }
}
